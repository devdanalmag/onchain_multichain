<?php
header("Content-Type: application/javascript");
?>
import { ethers } from "https://esm.sh/ethers@5.7.2";

let provider = null;
let signer = null;
let chainIdHex = null;
let rpcUrl = null;
let siteAddress = null;

async function getSiteSettings() {
    const res = await fetch("../../api/access.php?action=getSiteSettings");
    const json = await res.json();
    siteAddress = json.siteaddress || json.walletaddress || null;
    
    // Fetch assetchain config if available, else defaults
    const cfg = await fetch("../../config/assetchain.json").then(r => r.json()).catch(() => null);
    chainIdHex = cfg && cfg.chain_id ? "0x" + Number(cfg.chain_id).toString(16) : "0xa5a4"; // Default 42404
    rpcUrl = cfg && cfg.rpc_url ? cfg.rpc_url : "https://mainnet-rpc.assetchain.org/";
}

function setConnectedAddress(address) {
    const input = document.getElementById("wallet-add");
    const info = document.getElementById("walletdatainfo");
    if (input) {
        input.value = address;
        input.setAttribute("address-status", "0");
    }
    if (info) {
        info.setAttribute("connection", "1");
    }
    const btnDiv = document.getElementById("ton-connect-btn-div");
    if (btnDiv) {
        btnDiv.style.display = "none";
    }
    const purchaseBtnDiv = document.getElementById("purchase-btn-div");
    if (purchaseBtnDiv) {
        purchaseBtnDiv.style.display = "block";
    }
}

function clearConnection() {
    const input = document.getElementById("wallet-add");
    const info = document.getElementById("walletdatainfo");
    if (input) {
        input.value = "";
        input.setAttribute("address-status", "0");
    }
    if (info) {
        info.setAttribute("connection", "0");
    }
    const btnDiv = document.getElementById("ton-connect-btn-div");
    if (btnDiv) {
        btnDiv.style.display = "block";
    }
    const purchaseBtnDiv = document.getElementById("purchase-btn-div");
    if (purchaseBtnDiv) {
        purchaseBtnDiv.style.display = "none";
    }
}

async function ensureAssetChain() {
    const eth = window.ethereum;
    if (!eth) throw new Error("No EVM wallet found");

    const current = await eth.request({ method: "eth_chainId" });
    if (current !== chainIdHex) {
        try {
            await eth.request({
                method: "wallet_switchEthereumChain",
                params: [{ chainId: chainIdHex }]
            });
        } catch (switchErr) {
            // This error code indicates that the chain has not been added to MetaMask.
            if (switchErr.code === 4902 || switchErr.toString().includes("Unrecognized chain")) {
                await eth.request({
                    method: "wallet_addEthereumChain",
                    params: [{
                        chainId: chainIdHex,
                        chainName: "AssetChain",
                        nativeCurrency: {
                            name: "ASSET",
                            symbol: "ASSET",
                            decimals: 18
                        },
                        rpcUrls: [rpcUrl],
                        blockExplorerUrls: ["https://scan.assetchain.org/"]
                    }]
                });
            } else {
                 // Try adding it anyway if switch fails for other reasons, or rethrow
                 await eth.request({
                    method: "wallet_addEthereumChain",
                    params: [{
                        chainId: chainIdHex,
                        chainName: "AssetChain",
                        nativeCurrency: {
                            name: "ASSET",
                            symbol: "ASSET",
                            decimals: 18
                        },
                        rpcUrls: [rpcUrl],
                        blockExplorerUrls: ["https://scan.assetchain.org/"]
                    }]
                });
            }
        }
    }
}

window.connectEVMWallet = async function() {
    try {
        await getSiteSettings();
        await ensureAssetChain();

        provider = new ethers.providers.Web3Provider(window.ethereum, "any");
        // Request account access
        await provider.send("eth_requestAccounts", []);
        signer = provider.getSigner();
        const addr = await signer.getAddress();
        
        setConnectedAddress(addr);

        // Update balance display if exists
        const balWei = await provider.getBalance(addr);
        const bal = ethers.utils.formatEther(balWei);
        const amountEl = document.getElementById("amounttopayinton");
        if (amountEl) {
            amountEl.innerText = (Number(bal)).toFixed(4) + " Native";
        }

        // Listen for account changes
        window.ethereum.on("accountsChanged", (accounts) => {
            if (!accounts || accounts.length === 0) {
                clearConnection();
            } else {
                setConnectedAddress(accounts[0]);
            }
        });

        // Listen for chain changes
        window.ethereum.on("chainChanged", async () => {
            await ensureAssetChain();
            // window.location.reload(); 
        });

    } catch (e) {
        console.error(e);
        alert(e.message || "Wallet connection failed");
        clearConnection();
    }
}

window.disconnectWallets = function() {
    clearConnection();
}

async function ensureProvider() {
    if (!provider || !signer) {
        await window.connectEVMWallet();
    }
}

async function resolveWei() {
    const weiField = document.getElementById("native-to-pay");
    if (weiField && weiField.value) return weiField.value;

    const amtField = document.getElementById("amounttopay");
    const amount = amtField && amtField.value ? amtField.value : "0";

    // Call backend to get price in Wei (if amount is in fiat/other)
    const r = await fetch("../../api/access.php?action=checkNativePrice&amount=" + encodeURIComponent(amount));
    const j = await r.json();
    return j.amount_in_wei || j.weiamount || "0";
}

function setHidden(k, v) {
    let el = document.getElementById(k);
    if (!el) {
        el = document.createElement("input");
        el.type = "hidden";
        el.id = k;
        el.name = k;
        const wrap = document.getElementById("transaction-data");
        if (wrap) wrap.appendChild(el);
    }
    el.value = v;
}

function currentForm() {
    const p = document.getElementById("page-file-name");
    const n = p ? p.getAttribute("page-name") : "";
    if (n === "buy-airtime") return document.getElementById("airtimeForm");
    if (n === "buy-data") return document.getElementById("dataplanForm");
    // Add generic form fallback
    return document.getElementById("transaction-form") || null;
}

window.Sendtransaction = async function() {
    try {
        await ensureProvider();
        const addr = await signer.getAddress();
        const wei = await resolveWei();

        const tx = await signer.sendTransaction({
            to: siteAddress,
            value: ethers.BigNumber.from(String(wei))
        });

        const receipt = await tx.wait(1);

        // Fill hidden fields for backend processing
        setHidden("target_address", siteAddress || "");
        setHidden("user_address", addr || "");
        setHidden("tx_hash", receipt.transactionHash || tx.hash || "");
        setHidden("tx_lt", "0"); // Not used for EVM, but field might be expected
        setHidden("nanoamount", String(wei));

        const f = currentForm();
        if (f) {
             f.submit();
        } else {
             alert("Transaction successful, but form not found to submit.");
        }
    } catch (e) {
        console.error(e);
        alert(e.message || "Transaction failed");
    }
}
