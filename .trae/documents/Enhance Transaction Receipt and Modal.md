## Scope
Implement dynamic transaction receipt and modal UX across the app with minimal, focused changes. Primary updates in `loginstyle/receipt.html`; lightweight integration hooks in `dex/index.html` to trigger the SweetAlert2 modal after transactions.

## Receipt Template Updates (`loginstyle/receipt.html`)
1. Data binding via URL params: parse `status`, `amount`, `symbol`, `token`, `sender`, `target`, `txHash`, `timestamp`, `service`, `provider`, `recipient`, `fiatValue`, `reference` and render dynamically.
2. Status visualization:
   - Introduce CSS variables: `--status-success`, `--status-failed`, `--status-pending` (and neutral surface).
   - Map `status` → header background, icon (`fa-check`, `fa-xmark`, `fa-spinner`), label text (Success/Failed/Pending).
   - Use an accessible badge reflecting status with consistent colors.
3. Actions in receipt view:
   - Replace footer buttons with: `Save Image` and `Print`.
   - `Save Image`: capture `#receipt-root` using `html2canvas` and download PNG/JPEG.
   - `Print`: open a print-optimized window containing the same receipt markup, inject print CSS, trigger `window.print()`; include fallback to in-page `@media print`.
4. Technical details:
   - Include SweetAlert2 and html2canvas via CDN with `defer`.
   - Add responsive improvements (clamp widths, fluid typography, ensure small-screen readability).
   - Lazy-load non-critical assets (fonts/icons) and guard with feature detection.
   - Error handling: wrap save/print in `try/catch`, display SweetAlert2 error modals.
5. Receipt performance:
   - Avoid forced reflows; update DOM once after parsing params.
   - Use `requestIdleCallback` for image capture when available; fallback to `setTimeout`.
   - Cache parsed params in `sessionStorage` to reuse when re-opening.

## Modal Integration (`dex/index.html`)
1. After transaction completion inside `handleSend`/receipt pipeline, show SweetAlert2 modal:
   - Title and icon based on status.
   - Buttons: `View Receipt` (opens `loginstyle/receipt.html` with filled query params) and `Close`.
   - Preload `receipt.html` (hidden) to warm cache for fast open.
2. Ensure the receipt data matches the dynamic schema above; reuse existing receipt model fields already present in `createReceiptCard`.

## History Integration
- When opening receipts from history pages, link to `loginstyle/receipt.html` with the same param schema to render identical template and preserve `Save Image`/`Print` functionality.
- For `app/home/transaction-details.php`, align existing `#receipt-content` behavior to link or embed the updated `receipt.html`. Existing image capture code: see `app/home/includes/chainscript.php` (html2canvas usage).

## CSS Variables and Responsiveness
- Define in `:root`: `--status-success: #10B981`, `--status-failed: #EF4444`, `--status-pending: #F59E0B`, `--surface: #f3f4f6`, `--ink: #111827`.
- Apply variables to header background, icon wraps, badges.
- Add mobile-first layout rules; keep current Tailwind utility styling and refine where necessary.

## Error Handling
- `Save Image`/`Print`: catch errors, show `Swal.fire({ icon: 'error', text: '...'} )` with actionable copy.
- Validate required params (`txHash`, `timestamp`); show pending UI if missing; indicate offline mode if `sessionStorage` fallback is used.

## Performance Considerations
- Defer scripts; load SweetAlert2 and html2canvas only when actions occur.
- Use a simple in-memory cache of the rendered receipt state to avoid re-parsing on subsequent opens.
- Lazy-load icons/fonts; leverage browser caching for `receipt.html`.

## Testing Plan
- Status scenarios: success/failed/pending visual checks and modal content.
- Save image across browsers (Chrome, Edge, Firefox); verify fidelity.
- Print output: confirm margins, background graphics, and typography in A4 and Letter.
- History view parity: open from history and from fresh transaction; validate identical template and actions.

## File Changes
- Update `loginstyle/receipt.html`: dynamic binding, CSS variables, two action buttons, save/print functions, SweetAlert2/html2canvas integration.
- Update `dex/index.html`: include SweetAlert2, call modal after transaction, construct query string to open `receipt.html`. Reuse existing receipt model fields in `createReceiptCard`.

## Notes
- Existing html2canvas implementation reference: `app/home/includes/chainscript.php` and UI in `app/home/transaction-details.php`.
- No new files introduced; changes are constrained to the two existing files and reuse of current utilities where possible.