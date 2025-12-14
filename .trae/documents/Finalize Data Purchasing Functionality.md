I have analyzed the Data Purchasing implementation and identified a few critical issues in the backend that need to be fixed to make it "100% good and secured" like the Airtime section. The frontend logic in `dex/index.html` is already largely correct and shares the robust logic I implemented for Airtime.

Here is the plan to finalize the Data Purchasing functionality:

## Backend Fixes (`api/data/index.php`)
1.  **Fix Amount Overwrite Bug**: Remove the line `$tonamount = $controller->convertNanoToTon($nanoamount);`. This line currently overwrites the correctly calculated token amount with an empty/zero value (since `nanoamount` is not sent by the DEX), which would cause zero-value transaction records.
2.  **Fix Price Impact Logic**: Change `$controller->checkpriceimpact(...)` to `$controller->checkpriceimpactcngn(...)`. The current function uses legacy TON price logic which will fail for CNGN/USDT. Switching to the CNGN-specific check (like Airtime) ensures correct validation.
3.  **Dynamic Token Naming**: Update the transaction description (`$plandesc`) to use the dynamic `$token_name` variable instead of hardcoded "TON". This ensures the transaction history correctly says "CNGN", "USDT", etc.

## Backend Improvements (`api/airtime/index.php`)
1.  **Dynamic Token Naming**: Update the transaction description to use `$token_name` dynamically instead of hardcoded "CNGN". This is a small polish to ensure history is accurate if you add more tokens later.

## Frontend Verification (`dex/index.html`)
- Confirmed that `handleSend('data')` correctly sends `amount_wei`, `token_contract`, and handles the `ref` reset properly (which I added in the previous task).
- Confirmed that history rendering handles Data transactions correctly.
- **No changes required** on frontend, as it is already "good".

I will proceed with applying these backend fixes to ensure Data Purchasing works flawlessly.