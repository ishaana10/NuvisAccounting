# CHANGELOG & UPSTREAM 3.2.2 CATCH-UP

## [3.2.2] - 2026-08-17

### Updated from Upstream Akaunting 3.2.2
- **Import Encoding Sanitation**: Added `sanitizeRowEncoding` in `app/Abstracts/Import.php` to clean invalid UTF-8 bytes up front and prevent queue payload encoding failures.
- **Performance Fixes**:
  - Resolved Banking Accounts N+1 query issue.
  - Optimized report category loading and performance across reports.
- **Report & Document Enhancements**:
  - Fixed category type search and category component search issues.
  - Added transaction created and duplicating event support.
  - Fixed Profit & Loss date filter issue and PDF print formatting.
  - Enhanced invoice preview status handling.

### NuvisAccounting Rebranding & Maintenance
- Updated application branding, domain links (`https://nuvistechnologies.com.fj/accounting`), and contact email (`accounting@nuvistechnologies.com.fj`).
- Renamed static asset path to `public/nuvisaccounting-js/` and replaced logo with new Nuvis logo asset.
- Excluded development log files (`status.log`, `storage/logs/*.log`) in `.gitignore`.
- Updated `.env.example` with production defaults (`APP_DEBUG=false`, `FIREWALL_ENABLED=true`).
- Updated `package.json` version to 3.2.2.
