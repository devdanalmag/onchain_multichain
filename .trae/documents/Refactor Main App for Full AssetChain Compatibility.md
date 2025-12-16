## Scope and Goals
- Remove all TON blockchain components from the main app and replace with AssetChain (EVM) equivalents.
- Provide a unified, chain-agnostic wallet interface with multi-token support and PIN-protected address persistence.
- Standardize transaction processing across airtime/data/other services using AssetChain verification and app accounts (not DEX tokens).
- Integrate supported coins into P2P DB with complete metadata, price feeds, transaction records, and wallet mappings.
- Deliver full test coverage, security hardening, and performance optimizations, matching DEX reliability.

## Architecture Changes
- Replace TON with AssetChain modules:
  - Remove TON UI and SDKs: `app/home/includes/tonconnect-js.php`, `app/home/includes/connect.html`, `Tonconnects/*`, `assets/js/tonconnect-ui.min.js`.
  - Use AssetChain config: `config/assetchain.json` and DB-backed `getBlockchainConfig` in `core/Models/ApiModel.php:1018–1037`.
  - Standardize JSON‑RPC via `callJsonRpc` in `core/Models/ApiModel.php:1083–1112`.
- Normalize address storage:
  - Map `subscribers.sTonaddress` and `subscribers.tonaddstatus` to EVM addresses; use `normalizeEvmAddress` (`core/Controllers/Controller.php:147–157`).
  - Maintain field names to avoid risky migrations; update controller/model semantics to treat them as EVM.

## Wallet Connection System
- Create unified wallet adapter (shared JS) modeled on DEX wallet behavior:
  - Provider discovery (EIP‑1193/EIP‑6963), network enforcement, account change handling (reuse logic from `dex/index.html:1929–1956`, `1699–1727`, `2027–2078`).
  - ERC‑20 helpers: `getErc20Contract`, `sendTokenTransfer` (reference `dex/index.html:3182–3223`).
  - Dynamic token detection: fetch active tokens from backend (`dex/index.html:2226–2269` API pattern), expose balances via `eth_call`.
- Address persistence with PIN:
  - Server endpoints: use existing routes `core/Controllers/Subscriber.php:addwallet()` and PIN flows `updateTransactionPin()`.
  - Enforce PIN before persisting or using address (`core/Models/SubscriberModel.php:1196–1219`).
  - Store normalized address to `subscribers.sTonaddress`; set `tonaddstatus` when verified.

## Transaction Processing
- App-account only flow (no DEX tokens):
  - In `api/*` endpoints (airtime, data, electricity, cable), require valid app `Authorization` via `validateAccessToken` (`core/Models/ApiModel.php:18–41`).
  - Remove/disable `isDexToken` branches for main app requests; keep DEX support only where explicitly needed elsewhere.
- Multi-token support:
  - Validate token via `tokens` table and `token_contract`; normalize addresses; check balances with `checkERC20Balance` (`core/Models/ApiModel.php:1049–1081`).
  - AssetChain ERC‑20 payment verification using receipt/log matching (pattern in `api/airtime/index.php` and `core/Controllers/ApiAccess.php:629–812`).
- History & error handling:
  - Record with `recordchainTransaction` (`core/Models/ApiModel.php:565–612`), include `token_amount`, `token_name`, `token_contract`, optional `chain_id`.
  - Centralized failure handling and mandatory refunds (already implemented in airtime/data): use `refundTransaction` (`core/Models/ApiModel.php:364–474`) and `recordrefundchainTransaction` (`core/Models/ApiModel.php:613–665`).
  - Enforce transaction PIN where configured; reject when `sPinStatus` requires PIN and none provided.

## P2P Database Integration
- Coins metadata:
  - Populate `p2pcoins` via `core/Models/AdminModel.php:getCoins()`; add fields for symbol, name, `token_contract`, `decimals`, `status`.
  - Link price feeds: use CoinGecko `native_coin_id` from `sitesettings` (`core/Controllers/Subscriber.php:checkNativePrice`).
- Merchants:
  - Enhance `p2pmerchants` to store per‑coin price/limits (already via CSV); migrate to structured mapping if feasible, else keep CSV with validation.
- Transaction records & mappings:
  - Record P2P transactions in `transactions` with `servicename="P2P"`, `token_*` fields, `txhash`.
  - Map subscriber wallet (`sTonaddress`) to P2P flows; enforce PIN for P2P operations.

## Quality Assurance
- Unit tests (PHPUnit):
  - Models: `ApiModel` (RPC calls, verification), `SubscriberModel` (PIN, address), `AdminModel` (P2P coins/merchants).
  - Controllers: `ApiAccess` (verification), `Subscriber` (routes), `AdminController`.
- Integration tests:
  - AssetChain JSON‑RPC against a mocked provider; verify ERC‑20 transfer decoding and recording paths.
  - Refund flow: stub Deno endpoint and verify receipt handling.
- E2E tests:
  - UI wallet adapter, address persistence, purchase/record/refund, P2P listings; use Playwright/Cypress.
- Cross‑browser/device: run E2E across Chrome/Firefox/Safari mobile profiles.

## Security Requirements
- PIN‑based authorization:
  - Require PIN for sensitive operations based on `sPinStatus`; verify via `SubscriberModel::verifyTransactionPin`.
- Secure address storage:
  - Normalize and store; restrict updates to authenticated sessions; audit log address changes.
- Encrypted communications:
  - Enforce HTTPS; secure cookies/session; CSRF tokens on forms.
- Regular audits:
  - Add periodic job to reconcile on‑chain receipts vs DB; alert on mismatches.

## Performance Optimization
- RPC efficiency:
  - Cache price feed (TTL), batch JSON‑RPC where possible, avoid redundant `eth_getTransactionReceipt` calls.
- UI responsiveness:
  - Lazy load wallet adapter; debounce balance queries; minify shared JS.
- Database:
  - Index `transactions.txhash`, `tokens.token_contract`, `subscribers.sTonaddress` for faster lookups.

## Deliverables
- Fully functional main app with AssetChain integration (EVM wallet adapter, multi‑token support, app‑account auth, PIN‑protected address persistence).
- Documentation: architecture changes, configuration, operations, and user guide.
- Test suite with comprehensive unit/integration/E2E coverage; CI pipeline hooking into build/test.
- Deployment updates: environment variables for AssetChain RPC, refund service endpoints, and secure secrets handling.

## Implementation Phases
1. Remove TON components and wire AssetChain config and RPC helpers into main app.
2. Introduce shared wallet adapter; integrate across buy‑airtime/data/profile pages.
3. Enforce app‑account authorization and PIN in `api/*` endpoints; disable DEX token paths for main app requests.
4. Expand P2P DB metadata for coins; validate admin flows; connect price feeds.
5. Add tests (unit/integration/E2E) and CI pipeline; optimize RPC/UI performance.
6. Documentation and handover.

## Acceptance Criteria
- No TON dependencies remaining in the main app; AssetChain transactions and balances fully functional.
- Wallet connects reliably; addresses persist with PIN; multi‑token selections operate end‑to‑end.
- Transactions record correctly with refunds on failure; P2P listings reflect supported coins with prices.
- Test suite passes in CI; zero known errors; performance at least on par with current DEX experience.
