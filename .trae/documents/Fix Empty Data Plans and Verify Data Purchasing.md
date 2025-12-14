The empty data plans issue was caused by a mismatch in `api/access.php` between the network filter (which converted IDs to Names) and the database results (which returned IDs). I have fixed this by updating the filter logic to compare Network Names consistently.

Summary of changes:
1.  **Backend Fix (`api/access.php`)**:
    -   Updated `getDataPlans` to filter using the plan's network name (`$p->network`) instead of its ID (`$p->datanetwork`).
    -   Updated `checkDataPlanPrice` to also use the plan's network name for lookup.
    -   This ensures that whether the frontend sends a Network ID (e.g., "1") or Name (e.g., "MTN"), the API correctly matches it against the database record.

2.  **Verification**:
    -   Confirmed that `dex/index.html` sends the Network ID.
    -   Confirmed that `AdminModel` joins `dataplans` with `networkid`, providing the `network` name column required for the fix.
    -   Reviewed `api/data/index.php` and `api/airtime/index.php` to ensure they correctly handle network IDs, which they do.

The data plans dropdown should now populate correctly, and the data purchasing flow is aligned with the frontend.