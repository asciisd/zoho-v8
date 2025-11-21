<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Zoho CRM OAuth Client ID
    |--------------------------------------------------------------------------
    |
    | The OAuth Client ID obtained from Zoho API Console.
    |
    */
    'client_id' => env('ZOHO_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM OAuth Client Secret
    |--------------------------------------------------------------------------
    |
    | The OAuth Client Secret obtained from Zoho API Console.
    |
    */
    'client_secret' => env('ZOHO_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM OAuth Redirect URI
    |--------------------------------------------------------------------------
    |
    | The redirect URI registered in Zoho API Console.
    |
    */
    'redirect_uri' => env('ZOHO_REDIRECT_URI'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM Refresh Token
    |--------------------------------------------------------------------------
    |
    | The OAuth refresh token obtained after authorization.
    | This will be generated after running the setup command.
    |
    */
    'refresh_token' => env('ZOHO_REFRESH_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM Access Token
    |--------------------------------------------------------------------------
    |
    | The OAuth access token. This is automatically managed by the package.
    |
    */
    'access_token' => env('ZOHO_ACCESS_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM Environment
    |--------------------------------------------------------------------------
    |
    | The Zoho CRM environment to use. Options: production, sandbox, developer
    |
    */
    'environment' => env('ZOHO_ENVIRONMENT', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Zoho CRM Data Center
    |--------------------------------------------------------------------------
    |
    | The Zoho CRM data center location. Options: US, EU, IN, CN, JP, AU, CA
    |
    */
    'data_center' => env('ZOHO_DATA_CENTER', 'US'),

    /*
    |--------------------------------------------------------------------------
    | Token Storage Method
    |--------------------------------------------------------------------------
    |
    | How to store OAuth tokens. Options: cache, database, both
    | 'both' will use cache with database as fallback.
    |
    */
    'token_storage' => env('ZOHO_TOKEN_STORAGE', 'both'),

    /*
    |--------------------------------------------------------------------------
    | Cache Driver
    |--------------------------------------------------------------------------
    |
    | The cache driver to use for token storage when using cache or both.
    |
    */
    'cache_driver' => env('ZOHO_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),

    /*
    |--------------------------------------------------------------------------
    | Cache TTL
    |--------------------------------------------------------------------------
    |
    | The time-to-live for cached tokens in seconds. Default is 3600 (1 hour).
    |
    */
    'cache_ttl' => env('ZOHO_CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | Webhook Secret
    |--------------------------------------------------------------------------
    |
    | The secret key for verifying webhook signatures from Zoho CRM.
    |
    */
    'webhook_secret' => env('ZOHO_WEBHOOK_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Current User Email
    |--------------------------------------------------------------------------
    |
    | The email address of the Zoho CRM user for API operations.
    |
    */
    'current_user_email' => env('ZOHO_CURRENT_USER_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Application Log File Path
    |--------------------------------------------------------------------------
    |
    | The path where Zoho SDK logs will be stored.
    |
    */
    'application_log_file_path' => env('ZOHO_LOG_FILE_PATH', storage_path('logs/zoho_sdk.log')),

    /*
    |--------------------------------------------------------------------------
    | Sandbox Mode
    |--------------------------------------------------------------------------
    |
    | Enable sandbox mode for testing without affecting production data.
    |
    */
    'sandbox' => env('ZOHO_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | The Zoho CRM API version to use.
    |
    */
    'api_version' => 'v8',

    /*
    |--------------------------------------------------------------------------
    | Max Fields Per Request
    |--------------------------------------------------------------------------
    |
    | The maximum number of fields that can be requested in a single API call.
    | Zoho CRM API v8 has a limit of 50 fields per request.
    |
    */
    'max_fields_per_request' => env('ZOHO_MAX_FIELDS', 50),

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Default pagination settings for API requests.
    |
    */
    'pagination' => [
        'per_page' => env('ZOHO_PER_PAGE', 200),
        'max_records' => env('ZOHO_MAX_RECORDS', 200),
    ],

    /*
    |--------------------------------------------------------------------------
    | Model Sync Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for automatic model synchronization with Zoho CRM modules.
    |
    */
    'sync' => [
        /*
        | Enable or disable automatic model syncing globally.
        */
        'enabled' => env('ZOHO_SYNC_ENABLED', true),

        /*
        | The queue connection to use for sync jobs.
        */
        'queue' => env('ZOHO_SYNC_QUEUE', 'default'),

        /*
        | Number of times to retry failed sync jobs.
        */
        'retry_attempts' => env('ZOHO_SYNC_RETRY_ATTEMPTS', 3),

        /*
        | Backoff delays (in seconds) between retry attempts.
        */
        'retry_backoff' => [60, 120, 300], // 1 min, 2 min, 5 min
    ],
];
