# Zoho CRM Laravel Package (API v8)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/asciisd/zoho-v8.svg?style=flat-square)](https://packagist.org/packages/asciisd/zoho-v8)
[![Total Downloads](https://img.shields.io/packagist/dt/asciisd/zoho-v8.svg?style=flat-square)](https://packagist.org/packages/asciisd/zoho-v8)

A minimal and elegant Laravel wrapper for Zoho CRM PHP SDK 8.0. This package provides a clean, Laravel-style interface for interacting with Zoho CRM API v8 with model-like classes, automatic token management, and webhook support.

## Features

✅ **Model-like Interface** - Use intuitive model classes like `ZohoContact::create()`, `ZohoLead::find()`, etc.  
✅ **Automatic Token Management** - Hybrid cache + database token storage with auto-refresh  
✅ **Full CRUD Operations** - Create, Read, Update, Delete, Search, Upsert, and more  
✅ **Webhook Support** - Handle Zoho CRM webhooks with Laravel events  
✅ **Comprehensive Artisan Commands** - Easy setup, testing, and data synchronization  
✅ **Laravel 11+ Support** - Built for modern Laravel applications  
✅ **Minimal Code** - Super easy to integrate and use  
✅ **Multiple Data Centers** - Support for US, EU, IN, CN, JP, AU, CA  

## Requirements

- PHP 8.2 or higher
- Laravel 11.0 or higher
- Zoho CRM Account with API access

## Installation

Install the package via Composer:

```bash
composer require asciisd/zoho-v8
```

### Publish Configuration

Publish the configuration file and migrations:

```bash
php artisan vendor:publish --tag=zoho-config
php artisan vendor:publish --tag=zoho-migrations
```

### Run Migrations

Run the migration to create the OAuth tokens table:

```bash
php artisan migrate
```

### Configure Environment Variables

Add the following to your `.env` file:

```env
ZOHO_CLIENT_ID=your_client_id
ZOHO_CLIENT_SECRET=your_client_secret
ZOHO_REDIRECT_URI=your_redirect_uri
ZOHO_DATA_CENTER=US
ZOHO_ENVIRONMENT=production
```

## Quick Start

### 1. Authentication Setup

Run the setup command to authenticate with Zoho CRM:

```bash
php artisan zoho:setup
```

This interactive command will:
1. Generate an authorization URL
2. Accept your grant token/code
3. Generate and store access & refresh tokens
4. Test the connection

### 2. Basic Usage

#### Create a Contact

```php
use Asciisd\ZohoV8\Models\ZohoContact;

$contact = ZohoContact::create([
    'First_Name' => 'John',
    'Last_Name' => 'Doe',
    'Email' => 'john.doe@example.com',
    'Phone' => '+1234567890',
]);
```

#### Find a Contact

```php
$contact = ZohoContact::find('4150868000000624001');
```

#### Update a Contact

```php
ZohoContact::update('4150868000000624001', [
    'Phone' => '+0987654321',
    'Title' => 'Senior Developer',
]);
```

#### Delete a Contact

```php
ZohoContact::delete('4150868000000624001');
```

#### Get All Contacts

```php
$contacts = ZohoContact::all([
    'per_page' => 200,
    'page' => 1,
]);

foreach ($contacts as $contact) {
    echo $contact['Full_Name'];
}
```

#### Search Contacts

```php
// Search by email
$contacts = ZohoContact::searchByEmail('john.doe@example.com');

// Search by phone
$contacts = ZohoContact::searchByPhone('+1234567890');

// Custom search
$contacts = ZohoContact::search('(Last_Name:starts_with:Doe)');
```

#### Upsert (Create or Update)

```php
$contact = ZohoContact::upsert([
    'First_Name' => 'Jane',
    'Last_Name' => 'Smith',
    'Email' => 'jane.smith@example.com',
], ['Email']); // Duplicate check by Email
```

## Available Modules

The package provides model classes for all major Zoho CRM modules:

- `ZohoContact` - Contacts module
- `ZohoAccount` - Accounts module
- `ZohoLead` - Leads module
- `ZohoDeal` - Deals module
- `ZohoTask` - Tasks module
- `ZohoEvent` - Events module
- `ZohoCall` - Calls module
- `ZohoNote` - Notes module
- `ZohoProduct` - Products module
- `ZohoInvoice` - Invoices module

All modules extend the base `ZohoModel` class and support the same methods.

## Using the Facade

You can also use the `Zoho` facade for a fluent interface:

```php
use Asciisd\ZohoV8\Facades\Zoho;

// Create a contact
$contact = Zoho::contacts()->create([...]);

// Create a lead
$lead = Zoho::leads()->create([...]);

// Create a deal
$deal = Zoho::deals()->create([...]);
```

## Advanced Usage

### Get Related Records

```php
$deals = ZohoContact::getRelatedRecords('4150868000000624001', 'Deals');
```

### Update Multiple Records

```php
ZohoContact::updateMultiple([
    ['id' => '123', 'Phone' => '111'],
    ['id' => '456', 'Phone' => '222'],
]);
```

### Delete Multiple Records

```php
ZohoContact::deleteMultiple(['123', '456', '789']);
```

### Get Deleted Records

```php
$deletedContacts = ZohoContact::getDeletedRecords([
    'type' => 'permanent',
]);
```

### Convert Lead

```php
ZohoLead::convert('4150868000000624001', [
    'overwrite' => true,
    'notify_lead_owner' => true,
    'notify_new_entity_owner' => true,
]);
```

### Get Record Count

```php
$count = ZohoContact::count();
```

### Clone a Record

```php
$clonedContact = ZohoContact::clone('4150868000000624001');
```

## Artisan Commands

### Setup Authentication

```bash
php artisan zoho:setup
```

Interactive OAuth setup wizard.

### Authentication Management

```bash
# Show authentication status
php artisan zoho:auth status

# Show authorization URL
php artisan zoho:auth url

# Refresh access token
php artisan zoho:auth refresh

# Revoke access token
php artisan zoho:auth revoke
```

### Test CRUD Operations

```bash
# Test all operations on Contacts
php artisan zoho:test Contacts

# Test specific operation
php artisan zoho:test Leads --operation=create
```

### Sync Data

```bash
# Pull contacts from Zoho CRM
php artisan zoho:sync Contacts --direction=pull --limit=200

# Push contacts to Zoho CRM (requires implementation)
php artisan zoho:sync Contacts --direction=push
```

### Token Management

```bash
# Refresh access token
php artisan zoho:token:refresh

# Clear cached tokens
php artisan zoho:token:refresh --clear-cache
```

## Webhook Integration

### Setup Webhook in Zoho CRM

1. Go to **Setup** → **Developer Space** → **Webhooks**
2. Create a new webhook
3. Set URL to: `https://your-domain.com/zoho/webhook`
4. Select the modules and events you want to track

### Handle Webhook Events

Listen to webhook events in your application:

```php
use Asciisd\ZohoV8\Events\ZohoRecordCreated;
use Asciisd\ZohoV8\Events\ZohoRecordUpdated;
use Asciisd\ZohoV8\Events\ZohoRecordDeleted;
use Asciisd\ZohoV8\Events\ZohoWebhookReceived;

// Listen to all webhooks
Event::listen(ZohoWebhookReceived::class, function ($event) {
    $module = $event->module;
    $eventType = $event->event;
    $data = $event->getData();
    
    // Handle webhook
});

// Listen to specific events
Event::listen(ZohoRecordCreated::class, function ($event) {
    $module = $event->module; // e.g., 'Contacts'
    $record = $event->getData();
    $recordId = $event->getRecordId();
    
    // Handle record creation
});

Event::listen(ZohoRecordUpdated::class, function ($event) {
    // Handle record update
});

Event::listen(ZohoRecordDeleted::class, function ($event) {
    // Handle record deletion
});
```

### Webhook Security

Add a webhook secret to your `.env` file for signature verification:

```env
ZOHO_WEBHOOK_SECRET=your_secret_key
```

## Configuration

The package configuration file (`config/zoho.php`) includes:

```php
return [
    'client_id' => env('ZOHO_CLIENT_ID'),
    'client_secret' => env('ZOHO_CLIENT_SECRET'),
    'redirect_uri' => env('ZOHO_REDIRECT_URI'),
    'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
    'access_token' => env('ZOHO_ACCESS_TOKEN'),
    
    // Environment: production, sandbox, developer
    'environment' => env('ZOHO_ENVIRONMENT', 'production'),
    
    // Data Center: US, EU, IN, CN, JP, AU, CA
    'data_center' => env('ZOHO_DATA_CENTER', 'US'),
    
    // Token Storage: cache, database, both
    'token_storage' => env('ZOHO_TOKEN_STORAGE', 'both'),
    
    'cache_driver' => env('ZOHO_CACHE_DRIVER', 'file'),
    'cache_ttl' => env('ZOHO_CACHE_TTL', 3600),
    
    'webhook_secret' => env('ZOHO_WEBHOOK_SECRET'),
    
    'pagination' => [
        'per_page' => env('ZOHO_PER_PAGE', 200),
        'max_records' => env('ZOHO_MAX_RECORDS', 200),
    ],
];
```

## Error Handling

The package provides custom exceptions for better error handling:

```php
use Asciisd\ZohoV8\Exceptions\ZohoException;
use Asciisd\ZohoV8\Exceptions\ZohoAuthException;
use Asciisd\ZohoV8\Exceptions\ZohoApiException;
use Asciisd\ZohoV8\Exceptions\ZohoTokenException;

try {
    $contact = ZohoContact::find('invalid_id');
} catch (ZohoApiException $e) {
    // Handle API error
    echo $e->getMessage();
} catch (ZohoAuthException $e) {
    // Handle authentication error
} catch (ZohoTokenException $e) {
    // Handle token error
}
```

## Data Centers

The package supports all Zoho CRM data centers:

- `US` - United States (https://www.zohoapis.com)
- `EU` - Europe (https://www.zohoapis.eu)
- `IN` - India (https://www.zohoapis.in)
- `CN` - China (https://www.zohoapis.com.cn)
- `JP` - Japan (https://www.zohoapis.jp)
- `AU` - Australia (https://www.zohoapis.com.au)
- `CA` - Canada (https://www.zohoapis.ca)

Set your data center in `.env`:

```env
ZOHO_DATA_CENTER=EU
```

## Token Storage

The package supports three token storage methods:

1. **Cache Only** - Fast but volatile
2. **Database Only** - Persistent but slower
3. **Both** (Recommended) - Cache with database fallback

Configure in `.env`:

```env
ZOHO_TOKEN_STORAGE=both
```

## Testing

```bash
# Test Contacts module
php artisan zoho:test Contacts

# Test specific operations
php artisan zoho:test Leads --operation=create
php artisan zoho:test Accounts --operation=read
```

## Troubleshooting

### Token Expired Error

If you get a token expired error, refresh the token:

```bash
php artisan zoho:token:refresh
```

### Invalid Credentials

Make sure your `.env` file has the correct credentials:

```bash
php artisan zoho:auth status
```

### Rate Limit Exceeded

Zoho CRM has API rate limits. The package will throw a `ZohoApiException` with code 429. Implement retry logic with exponential backoff.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security

If you discover any security-related issues, please email aemaddin@gmail.com instead of using the issue tracker.

## Credits

- [Ascii SD](https://github.com/asciisd)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

For support, please open an issue on GitHub or contact aemaddin@gmail.com.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

