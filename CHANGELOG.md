# CHANGELOG & MIGRATION ROADMAP

## [3.2.2] - 2026-08-17

### Added / Updated
- Rebranded assets and public JavaScript paths (`public/nuvisaccounting-js/`).
- Updated project branding, domain configuration (`https://nuvistechnologies.com.fj/accounting`), and security contact email (`accounting@nuvistechnologies.com.fj`).
- Configured production defaults in `.env.example` (`APP_DEBUG=false`, `FIREWALL_ENABLED=true`).
- Cleaned development artifacts (`status.log`) and enforced git tracking exclusions for build artifacts, vendors, and logs.
- Prepared package.json and release documentation for version 3.2.2 upstream catch-up.

## Future Architecture Roadmap & Recommendations

### 1. Vue 2 to Vue 3 Upgrade
- **Current State**: Vue 2 is utilized in resources/assets/js.
- **Action Plan**:
  - Migrate Vue options API components to Vue 3 Composition API.
  - Upgrade Vue router (`vue-router` v4) and state management/utility dependencies.
  - Test custom Vue components and Element UI migration to Element Plus.

### 2. Framework & PHP Upgrade
- **Current State**: Laravel 10 and PHP 8.1 platform constraint.
- **Action Plan**:
  - Prepare dependencies for Laravel 11 / PHP 8.2+ compatibility.
  - Refactor obsolete helpers and update overridden core packages under `overrides/`.

### 3. Dependency Security Audits
- **Action Plan**:
  - Periodically review `audit.ignore` list in `composer.json`.
  - Update secondary packages to patch advisories directly rather than ignoring advisories.

### 4. Custom Packages Distribution
- **Action Plan**:
  - Evaluate publishing `nuvisaccounting/*` packages to private Satis/Packagist repositories rather than path overrides in `overrides/nuvisaccounting/`.
