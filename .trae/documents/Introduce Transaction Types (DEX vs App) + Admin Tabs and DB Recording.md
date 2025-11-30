## Overview

Implement transaction categorization (DEX, App), record token metadata (name, contract) with each successful transaction, and add two tabs on the admin Transactions page to view DEX vs App.

## Database

1. Add columns to `transactions` table:

   * `transaction_type` ENUM('dex','app') NOT NULL DEFAULT 'app'

   * `token_name` VARCHAR(64) NULL

   * `token_contract` VARCHAR(66) NULL
2. Backfill migration:

   * Set `transaction_type='app'` for existing rows

   * Leave `token_name` and `token_contract` NULL if unknown
3. Indexes:

   * Add index on `transaction_type`

   * Optional composite index `(transaction_type, created_at)` for fast tab queries

## Backend Recording

1. Determine type:

   * In API endpoints (airtime, data): use existing `isDexToken` flag

   * Map `isDexToken === true` → `transaction_type='dex'`; else `'app'`
2. Determine token metadata:

   * From request payload: `token_contract` (already present for Assetchain ERC-20)

   * Token name resolution:

     * If `token_contract` matches known mapping in `config/assetchain.json`, use that name (e.g., `cNGN`)

     * If no contract provided, treat as native coin (`ASET`), set `token_name='ASET'`, `token_contract=NULL`
3. Extend model methods:

   * `recordchainTransaction(...)` add params `transaction_type, token_name, token_contract`

   * `updateTransactionStatus(...)` no change to type, but ensure stored token metadata persists

   * `recordrefundchainTransaction(...)` include token metadata (use same as original txn)
4. Controller wiring:

   * In `api/airtime/index.php` and `api/data/index.php`, compute `transaction_type`, `token_name`, `token_contract` before calling record functions

   * Pass new params through `ApiAccess` → `Model`

## Admin UI

1. Transactions Admin page:

     the admin transaction page on ` adminsofonchainng\dashboard\transactions.php`

   * Add two tabs: `DEX` and `App `&#x20;

   * Each tab queries `transactions` filtered by `transaction_type`

   * Columns include: date/time, ref, user, service, amount, `token_name`, `token_contract`, status, tx\_hash
2. Filtering and pagination:

   * Add quick filters by date range and status

   * Paginate results (e.g., 50 per page)
3. Detail view:

* Transaction detail page shows full metadata including token info and on-chain links

## API/Controller Adjustments

1. Ensure verification flow remains unchanged; only recording enriched metadata and type
2. For DEX provider outages, still record success if verification passes (as already adjusted) and store type/token

## Testing

1. Unit tests for:

* Recording with `transaction_type='dex'` and token metadata

* Recording with `transaction_type='app'` and native coin

* Admin queries correctly separate tabs and show metadata

1. Manual E2E:

* DEX flow: send CNGN transfer, verify, record, visible in DEX tab

* App flow: traditional app tokenless purchase (native), visible in App tab

## Rollout

1. Migration script with safe defaults
2. Backward compatibility: model signatures accept old calls via default values until all call sites updated

## Notes

* No secrets in code; token name mapping is config-driven

* Keep consistent casing: `transaction_type` stored as lowercase `dex`/`app`

## Confirmation

If you approve, I will implement DB migration, update model/controller methods, wire the API endpoints to pass type and token metadata, and create the admin tabs and filters as described.
