# Changelog

All notable changes to `zoho-v8` will be documented in this file.

## 1.0.1 - 2025-11-21

### Fixed

- Fixed invalid `fields=All` parameter issue - now dynamically fetches actual field names from Zoho CRM API
- Field names are now automatically retrieved from `/settings/fields` endpoint for each module
- Added field name caching to improve performance and reduce API calls
- Added required `fields` parameter to all GET requests to comply with Zoho CRM v8 API requirements
- Updated `all()`, `find()`, `search()`, `getRelatedRecords()`, and `getDeletedRecords()` methods to use actual field names
- Fixed "REQUIRED_PARAM_MISSING" error when fetching records from Zoho CRM
- Added missing OAuth callback route (`/zoho/callback`) to handle authorization flow

### Added

- New `getModuleFieldNames()` method to fetch and cache field names for each module
- New `getDefaultFields()` fallback method for when field metadata fetch fails
- Automatic fallback to common system fields if field metadata fetch fails

### Changed

- `default_fields` configuration is now deprecated - field names are fetched automatically
- `find()` method now accepts optional `$params` array as second parameter
- `getRelatedRecords()` method now accepts optional `$params` array as third parameter

### Deprecated

- `default_fields` configuration option (kept for backward compatibility but no longer used)

## 1.0.0 - 2024-01-01

### Added

- Initial release
- Model-like interface for all Zoho CRM modules
- Automatic OAuth token management with hybrid cache + database storage
- Full CRUD operations (Create, Read, Update, Delete, Search, Upsert)
- Webhook support with Laravel events
- Comprehensive Artisan commands:
  - `zoho:setup` - Interactive OAuth setup
  - `zoho:auth` - Authentication management
  - `zoho:test` - CRUD operations testing
  - `zoho:sync` - Data synchronization
  - `zoho:token:refresh` - Token refresh
- Support for all Zoho CRM data centers (US, EU, IN, CN, JP, AU, CA)
- Custom exception classes for better error handling
- Laravel 11+ support
- PHP 8.2+ support

### Features

- ZohoContact, ZohoAccount, ZohoLead, ZohoDeal models
- ZohoTask, ZohoEvent, ZohoCall, ZohoNote models
- ZohoProduct, ZohoInvoice models
- Facade support for fluent interface
- Webhook signature verification
- Automatic token refresh
- Related records support
- Batch operations (update/delete multiple records)
- Lead conversion support
- Record count and search capabilities
- Clone record functionality
