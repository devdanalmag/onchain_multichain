<script type="module">
    import { Address, beginCell, Cell } from 'https://esm.sh/@ton/core';
    import { TonClient } from 'https://esm.sh/@ton/ton';
    import { sha256 } from 'https://esm.sh/@ton/crypto';

    // const TARGETADDRESS = '0:614a6ab7f8b855c36d06c71194a4cf3e208e38f584fddd3a1cfe8645286606e0';
    const TARGETADDRESS = 'UQBhSmq3-LhVw20GxxGUpM8-II449YT93Toc_oZFKGYG4Foj';

    // Create a TON client using the mainnet endpoint.
    const client = new TonClient({
      endpoint: 'https://toncenter.com/api/v2/jsonRPC',
      apiKey: '2ad5a114b9db4ed117861301988ddee4d53765c6a22e7ac1e579bc683e7355b3',
    });

    // Initialize TON Connect UI
    const tonConnectUI = new TON_CONNECT_UI.TonConnectUI({
      manifestUrl: 'https://onchain.com.ng/app/home/tonconnect-manifest.json',
      buttonRootId: 'ton-connect-btn',
    });

    console.error(TON_CONNECT_UI);

    // When wallet status changes (connect/disconnect)
    tonConnectUI.onStatusChange(async (status) => {
      if (status) {
        const rawAddress = status.account.address;

        // Check if wallet appears to be a testnet wallet by its appName.
        const isTestnet =
          tonConnectUI.wallet?.device?.appName?.toLowerCase().includes(
            'testnet'
          );
        if (isTestnet) {
          alert(
            'Testnet wallets are not allowed. Please connect a mainnet wallet.'
          );
          tonConnectUI.disconnect();
          return;
        }

        // Convert raw address to a mainnet-friendly format
        const userFriendlyAddress = Address.parse(rawAddress).toString({
          testOnly: false,
          bounceable: false,
        });

        document.getElementById(
          'wallet-info'
        ).innerHTML = `<p>Connected Wallet Address: ${userFriendlyAddress}</p>`;

        // Show transaction form
        document.getElementById('transaction-form').style.display = 'block';

        // Fetch wallet balance from mainnet
        try {
          const response = await fetch(
            `https://toncenter.com/api/v2/getAddressBalance?address=${encodeURIComponent(
              userFriendlyAddress
            )}&api_key=2ad5a114b9db4ed117861301988ddee4d53765c6a22e7ac1e579bc683e7355b3`
          );
          if (!response.ok) {
            throw new Error('Failed to fetch wallet balance');
          }
          const data = await response.json();
          const balance = data.result / 1e9;
          document.getElementById('wallet-info').innerHTML += `<p>Wallet Balance: ${balance} TON</p>`;
        } catch (error) {
          console.error('Error fetching wallet balance:', error);
          document.getElementById('wallet-info').innerHTML +=
            '<p>Failed to fetch wallet balance. Please try again later.</p>';
        }
      } else {
        document.getElementById('ton-viewer-link').innerHTML = '';
        document.getElementById('transaction-info').style.display = 'none';
        document.getElementById('wallet-info').innerHTML = '';
        document.getElementById('transaction-form').style.display = 'none';
      }
    });

    // Event listener for sending a transaction.
    document
      .getElementById('send-transaction')
      .addEventListener('click', async () => {
        const amount = parseFloat(document.getElementById('amount').value);
        if (isNaN(amount) || amount <= 0) {
          alert('Please enter a valid amount.');
          return;
        }

        const rawAddress = tonConnectUI.wallet?.account?.address;
        if (!rawAddress) {
          alert('Wallet is not connected.');
          return;
        }

        const amountInNano = BigInt(Math.floor(amount * 1e9));
        // Replace the target address below with your own mainnet address.
        // const targetAddress = Address.parse(TARGETADDRESS);
        const targetAddress = TARGETADDRESS;
        // Create the transaction object.
        const transaction = {
          validUntil: Math.floor(Date.now() / 1000) + 600,
          messages: [
            {
              address: targetAddress.toString(),
              amount: amountInNano.toString(),
            },
          ],
        };

        try {
          // Send the transaction via TON Connect.
          const result = await tonConnectUI.sendTransaction(transaction);
          console.log('Transaction sent:', result);

          // Parse the transaction BOC to extract a transaction hash.
          const cell = Cell.fromBase64(result.boc);
          const hashBuffer = cell.hash();
          const txHash = hashBuffer.toString('hex');
          console.log('Transaction Hash:', txHash);
          console.log('User Raw Address', rawAddress);
          console.log('Target Address', targetAddress.toString());
          // Display preliminary transaction details.
          document.getElementById('target-account').textContent = targetAddress.toString();
          document.getElementById('tx-hash').textContent = txHash;

          // Now poll the mainnet to confirm the transaction and retrieve its lt.
          const lt = await verifyTransaction(txHash, TARGETADDRESS.toString(), rawAddress);
          if (lt) {
            // Display the lt value once the transaction is confirmed.
            // document.getElementById('tx-lt').textContent = lt;
            // Display TON Viewer link on success.
            alert('Transaction confirmed on mainnet!');
            const tonViewerLink = `https://tonviewer.com/transaction/${txHash}`;
            document.getElementById('ton-viewer-link').innerHTML = `<a href="${tonViewerLink}" target="_blank">${tonViewerLink}</a>`;
            document.getElementById('transaction-info').style.display = 'block';
          } else {
            alert(
              'Transaction not confirmed on mainnet within the expected time. Please try again.'
            );
          }
        } catch (error) {
          console.error('Transaction error:', error);
          alert('Failed to send or verify transaction. Please try again.');
        }
      });



    // Function to poll for transaction confirmation on mainnet.
    async function verifyTransaction(txHash, targetAddress, rawAddress) {
      const maxAttempts = 10; // Maximum number of polling attempts
      const interval = 2000; // Interval in milliseconds (5 seconds)
      let attempts = 0;

      while (attempts < maxAttempts) {
        console.log(`Polling for transaction confirmation... Attempt ${attempts + 1}/${maxAttempts}`);
        // Construct the URL for getTransactions API with lt and to_lt
        const url = `https://tonapi.io/v2/blockchain/messages/${txHash.toString()}/transaction`;
        try {
          const response = await fetch(url);
          const data = await response.json();
          const targetFriendlyAddress = Address.parse(data.out_msgs[0].destination.address).toString({
            testOnly: false,
            bounceable: false,
          });

          if (data.account.address.toString() === rawAddress.toString()
            && data.success === true
            && targetFriendlyAddress === targetAddress
            && data.in_msg.hash.toString() === txHash.toString()
          ) {
            console.log('Transaction confirmed:', data);
            return true;
          }
          else {
            console.error('Error in response:', data.error);
          }
        } catch (error) {
          console.error('Error fetching transaction:', error);
        }

        // Wait before the next attempt
        await new Promise((resolve) => setTimeout(resolve, interval));
        attempts++;
      }
      return null;
    }
  </script>