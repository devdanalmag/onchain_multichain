// send-evm-refund.ts
import { serve } from "https://deno.land/std@0.177.0/http/server.ts";
import { ethers } from "https://esm.sh/ethers@5.7.2";

const PRIVATE_KEY = Deno.env.get("PRIVATE_KEY")?.trim();
const RPC_URL = Deno.env.get("RPC_URL")?.trim();

if (!PRIVATE_KEY || !RPC_URL) {
  console.log(JSON.stringify({ success: false, message: "Missing .env variables!" }));
}

const provider = new ethers.providers.JsonRpcProvider(RPC_URL);
const wallet = new ethers.Wallet(PRIVATE_KEY!, provider);

serve(async (req) => {
  try {
    if (req.method !== "POST") return new Response("Method Not Allowed", { status: 405 });

    const { address, amount, token_contract, token_decimals, msgs } = await req.json();
    
    if (!address || !amount) throw new Error("Missing address or amount");

    console.log(`Processing refund: ${amount} to ${address} (Token: ${token_contract || 'Native'})`);

    let txResponse;
    
    if (token_contract && token_contract !== '0x0000000000000000000000000000000000000000') {
      // ERC20 Token Transfer
      const abi = [
        "function transfer(address to, uint256 amount) returns (bool)",
        "function decimals() view returns (uint8)"
      ];
      const contract = new ethers.Contract(token_contract, abi, wallet);
      
      // Parse amount with correct decimals
      const decimals = token_decimals || await contract.decimals();
      const amountWei = ethers.utils.parseUnits(String(amount), decimals);
      
      // Gas estimation
      const gasLimit = await contract.estimateGas.transfer(address, amountWei);
      const gasPrice = await provider.getGasPrice();
      
      txResponse = await contract.transfer(address, amountWei, {
        gasLimit: gasLimit.mul(120).div(100), // +20% buffer
        gasPrice
      });
    } else {
      // Native Asset Transfer
      const amountWei = ethers.utils.parseEther(String(amount));
      
      const gasLimit = await provider.estimateGas({
        to: address,
        value: amountWei
      });
      const gasPrice = await provider.getGasPrice();

      txResponse = await wallet.sendTransaction({
        to: address,
        value: amountWei,
        gasLimit: gasLimit.mul(120).div(100),
        gasPrice
      });
    }

    console.log(`Transaction sent: ${txResponse.hash}`);
    
    // Wait for 1 confirmation
    const receipt = await txResponse.wait(1);

    console.log(
      JSON.stringify({
        success: true,
        message: "Refund successful",
        address: address,
        amount: amount,
        msgs: msgs,
        hash: receipt.transactionHash
      })
    );

    return new Response(JSON.stringify({
      success: true,
      message: "Refund successful",
      address: address,
      amount: amount,
      msgs: msgs,
      hash: receipt.transactionHash
    }), { headers: { "Content-Type": "application/json" } });

  } catch (error: any) {
    console.log(
      JSON.stringify({
        success: false,
        message: error.message || "Error occurred",
        stack: error.stack,
      })
    );
    return new Response(JSON.stringify({
      success: false,
      message: error.message || "Error occurred",
      error: error.toString()
    }), { status: 500, headers: { "Content-Type": "application/json" } });
  }
});
