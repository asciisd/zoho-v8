# Changelog

All notable changes to `zoho-v8` will be documented in this file.

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

