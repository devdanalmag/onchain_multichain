## Database Schema & Migration

1. Create `tokens` table:

   * `token_id` INT AUTO\_INCREMENT PRIMARY KEY

   * `token_name` VARCHAR(64) NOT NULL

   * `token_contract` VARCHAR(66) NOT NULL

   * `token_decimals` INT NOT NULL

   * `created_at` TIMESTAMP DEFAULT CURRENT\_TIMESTAMP

   * `updated_at` TIMESTAMP DEFAULT CURRENT\_TIMESTAMP ON UPDATE CURRENT\_TIMESTAMP

   * `is_active` TINYINT(1) NOT NULL DEFAULT 1
2. Indexes: `INDEX idx_token_name (token_name)`, `INDEX idx_token_contract (token_contract)`.
3. Seed tokens:

   * CNGN: contract from `config/assetchain.json`, decimals=6

   * USDT: `0x26E490d30e73c36800788DC6d7415946C4BbEa24`, decimals=18 , is\_active=1.
4. Safe migration script: create table if not exists; add indexes if missing; upsert seed rows.

## Backend API Changes

1. Add new endpoints or actions:

   * `GET /api/access.php?action=getTokens` → returns active tokens `[token_name, token_contract, token_decimals]`.

   * `POST /api/admin/tokens` (admin-only) → create/update/enable/disable tokens (use existing admin auth framework).
2. Update existing flows to be DB-driven:

   * `api/airtime/index.php` and `api/data/index.php`: receive `token_contract` or `token_name`; resolve via DB; validate `is_active`; get `decimals` and pass to verification.

   * `core/Controllers/ApiAccess.php::verifyAssetTransaction` → remove hardcoded default; require explicit `token_contract` and compare strictly.

   * Normalize addresses via existing `normalizeEvmAddress` before DB lookup and comparison.
3. Error handling:

   * Missing token → 400 `Token Not Found`.

   * Inactive token → 400 `Token Disabled`.

   * Invalid address format → 400 `Invalid Contract Address`.

   * Network/DB failures → 500 `Server Error` with safe messages.

## Frontend (DEX) Changes

1. Token selector:

   * Fetch tokens from `GET /api/access.php?action=getTokens` on page load.

   * Dropdown to choose token for airtime/data.

   * Use selected token’s `token_contract` and `token_decimals` for amount conversion and transfer.
2. Transfer logic:

   * Build ERC‑20 contract dynamically with selected `token_contract`.

   * Convert Naira→wei using selected token’s `token_decimals`.

   * Post `token_contract` and `amount_wei` to backend.
3. Validation & UX:

   * Disable send until token is loaded and valid.

   * Clear messaging when tokens list is empty or network errors occur.

## Admin Maintenance Interface

1. Add Admin page under dashboard:

   * List tokens with pagination, filters (name/contract/is\_active).

   * Create/update forms: `token_name`, `token_contract` (validate EVM address), `token_decimals`, `is_active`.

   * Enable/Disable actions.
2. Backend handlers reuse AdminModel with prepared statements and validation.

## Tests

1. Unit tests (PHP):

   * DB connection and `tokens` CRUD.

   * `getTokens` returns only active tokens; case-insensitive lookups by name; strict address validation.

   * Transaction verification uses DB decimals and contract; fails when token inactive or missing.
2. Frontend (JS):

   * Token dropdown renders from API and handles an empty list.

   * Amount conversion uses token decimals.

   * Payload includes selected `token_contract` and computed `amount_wei`.

## Error Handling & Security

* Validate inputs server-side; use `textContent` for dynamic text; avoid HTML injection.

* Strict EVM address regex and normalization.

* Fail closed on DB/network errors with clear user messages.

## Documentation

* Add schema description and API changes:

  * `tokens` table columns and indexes.

  * `GET /api/access.php?action=getTokens` response format.

  * Required frontend fields: `token_contract`, `amount_wei`, `token_decimals` usage.

* Admin maintenance operations (add/update/enable/disable).

## Implementation Order

1. DB migration + seed.
2. Backend `getTokens` + DB-driven verification.
3. Frontend token dropdown + dynamic transfer.
4. Admin maintenance UI.
5. Tests and finalize error handling.

Confirm and I will implement the DB migration, API, frontend selector, admin UI, and tests.
