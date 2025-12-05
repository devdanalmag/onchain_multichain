## Targets
- `dex/index.html`: `openReceiptModal(model)`, `openTxModal(item)`, `renderReceipt(model)`, `createReceiptCard(model)`.

## Changes
1. Remove From/To fields
- In both renderers, delete or skip rendering blocks showing `From` and `To` (renderReceipt: 2315–2318; createReceiptCard: 2382–2386).

2. Add Service field
- Extend `openTxModal(item)` to derive `service` from the purchase context (airtime/data). Use existing form values or `item.serviceType` if present.
- Add a new row in both renderers: label `Service`, value from `model.service` (e.g., “Airtime Purchase” or “Data Purchase”).

3. Purchase value display
- In `openTxModal(item)`, compute `model.purchaseValue`:
  - Airtime: `<amount>N Airtime` using the naira amount input.
  - Data: `<size> Data` (e.g., `1GB Data`) using selected plan label.
- Add a new row in both renderers: label `Value`, value from `model.purchaseValue`.

4. Title update
- Change modal title from “Transaction Receipt” to “Transaction Summary” in `openReceiptModal(model)` and card header in both renderers.

5. Buttons
- Replace footer buttons with:
  - View Receipt: opens `loginstyle/receipt.html?` with the same params used previously (status, amount, symbol, token, sender, target, txHash, timestamp, service, provider, recipient, fiatValue, reference). Use `window.open(url, '_blank')`.
  - Check Explorer: build AssetChain Explorer URL from `model.hash` and `model.chainId` (or current network), then `window.open(explorerUrl, '_blank')`.

6. New tabs behavior
- Ensure both actions use `window.open(..., '_blank')` and add `rel="noopener"` where inserting anchor tags.

7. Preserve metadata
- Keep existing date/time/status sections untouched.
- Ensure `model.status`, `model.timestamp`, `model.amountDisplay`, `model.symbol` are still shown.

8. Responsive design
- Use existing tailwind utility classes; ensure long values wrap (use `break-all` for hashes).
- Verify card layout within modal scales on mobile (max width, padding).

9. Preserve functionality
- Leave transaction copy buttons and status badge logic intact.
- Keep print/download functions if used elsewhere; only swap visible footer buttons per spec.

10. Data processing updates
- In `openTxModal(item)`, populate new `model.service` and `model.purchaseValue` by reading from current UI:
  - Airtime: network select and amount input.
  - Data: network select and plan label/size.
- Fallbacks if fields absent: use `item.serviceType` and `item.fiatAmount` or `item.planName`.

## Explorer URL
- AssetChain Explorer: `https://explorer.assetchain.org/tx/${model.hash}` (replace with correct base if different in the app config). If a config object exists (e.g., `NETWORKS[chainId].explorer`), use that.

## Testing
- Verify card renders without From/To.
- Confirm Service and Value rows show correct content for airtime and data purchases.
- Title shows “Transaction Summary”.
- Buttons open in new tabs: receipt URL and explorer transaction page.
- Check responsive wrapping of long hashes.
- Ensure no regressions in other metadata sections.

## Files affected
- Only `dex/index.html` (modal/card builders). No new files created.

## Rollback
- Changes isolated to renderer and modal functions; easy to revert by restoring previous blocks if needed.