# Assetchain + CNGN Migration

## Overview
- Backend now verifies on-chain payments on Assetchain and requires ERC‑20 CNGN transfers.
- New helpers added in `core/Controllers/ApiAccess.php`:
  - `verifyAssetTransaction(tx_hash, from, to, amount_wei, token_contract)`
  - `normalizeEvmAddress(address)`
  - `convertWeiToToken(wei, decimals=18)`
  - `checkPriceImpactCngn(price, tokenAmount)`
- `api/airtime/index.php` switched from TON fields to Assetchain:
  - Requires `amount_wei` and validates ERC‑20 transfer to the site address.
  - Disables TON-specific refund path for DEX-based requests.
  - Compares normalized EVM addresses.

## Configuration
- File: `config/assetchain.json`
  - `rpc_url`: `https://mainnet-rpc.assetchain.org/`
  - `chain_id`: `42420`
  - `site_address`: Your receiving EVM address on Assetchain.
  - `cngn_contract`: CNGN token contract (default provided).

## Airtime API Payload (Assetchain)
POST `api/airtime/`
- Required JSON fields:
  - `network` (e.g., `MTN`)
  - `phone` (MSISDN)
  - `amount` (NGN amount)
  - `airtime_type` (`VTU` or `Share And Sell`)
  - `ref` (unique reference)
  - `target_address` (site address on Assetchain)
  - `user_address` (sender’s EVM address)
  - `tx_hash` (Assetchain transaction hash)
  - `amount_wei` (CNGN amount in wei)
  - `token_contract` (CNGN contract address)

Authorization: `Authorization: Token <dex_token>` or your existing API token.

## Verification Logic
- Step 1: Fetch `https://scan.assetchain.org/api/v2/transactions/<tx_hash>` and ensure `status == ok`.
- Step 2: Fetch `https://scan.assetchain.org/api/v2/transactions/<tx_hash>/token-transfers?type=ERC-20%2CERC-721%2CERC-1155`.
- Accept only when any `items` entry matches:
  - `from.hash == user_address`.
  - `to.hash == target_address`.
  - `token.address == token_contract`.
  - `total.value == amount_wei` (string-exact match).

## DEX Frontend Updates
- Switch sending from TON to Assetchain (MetaMask or equivalent):
  - Use `ethers.js` to call `transfer(target, amount_wei)` on CNGN contract.
  - Include `amount_wei` and `token_contract` in API payload, no `tx_lt`.
  - Keep `Authorization: Token <dex_token>` header.
- Minimal example (browser):
```
const provider = new ethers.providers.Web3Provider(window.ethereum);
await provider.send('eth_requestAccounts', []);
const signer = provider.getSigner();
const cngn = new ethers.Contract(
  '0x7923C0f6FA3d1BA6EAFCAedAaD93e737Fd22FC4F',
  ['function transfer(address to, uint256 value) returns (bool)'],
  signer
);
const tx = await cngn.transfer(siteAddress, amountWei);
const receipt = await tx.wait();
// Use receipt.transactionHash in API payload
```

## Testing
- Ensure `config/assetchain.json` has your `site_address`.
- Send a real CNGN transfer on Assetchain, then POST to `api/airtime/` with the `tx_hash` and `amount_wei`.
- Sample local test helper: `test_assetchain_airtime.php`.

## Notes
- Refunds: On-chain refunds are disabled for DEX Assetchain flow unless implemented for ERC‑20.
- Data, cable, and other services should replicate the airtime changes (inputs, verification, conversions).