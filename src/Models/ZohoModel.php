<?php

namespace Asciisd\ZohoV8\Models;

use Asciisd\ZohoV8\Exceptions\ZohoApiException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class ZohoModel
{
    /**
     * The Zoho CRM module API name.
     * Must be defined in child classes.
     */
    protected const MODULE_API_NAME = '';

    /**
     * Get the module API name.
     */
    protected static function getModuleApiName(): string
    {
        $class = static::class;
        if (empty($class::MODULE_API_NAME)) {
            throw ZohoApiException::invalidModule('Module API name not defined');
        }
        return $class::MODULE_API_NAME;
    }

    /**
     * Get OAuth manager instance.
     */
    protected static function getOAuthManager()
    {
        return app('zoho.oauth');
    }

    /**
     * Get the base API URL.
     */
    protected static function getApiUrl(): string
    {
        $baseUrl = static::getOAuthManager()->getApiUrl();
        $version = config('zoho.api_version', 'v8');
        return "{$baseUrl}/crm/{$version}";
    }

    /**
     * Make an API request.
     */
    protected static function makeRequest(string $method, string $endpoint, array $data = []): array
    {
        try {
            $accessToken = static::getOAuthManager()->getValidAccessToken();
            $url = static::getApiUrl() . $endpoint;

            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->$method($url, $data);

            if (!$response->successful()) {
                $error = $response->json('message', 'API request failed');
                $code = $response->status();
                throw ZohoApiException::requestFailed($error, $code);
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Zoho API request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create a new record.
     */
    public static function create(array $data): array
    {
        $module = static::getModuleApiName();
        
        $payload = [
            'data' => [$data],
        ];

        $response = static::makeRequest('post', "/{$module}", $payload);

        if (isset($response['data'][0])) {
            return $response['data'][0];
        }

        return $response;
    }

    /**
     * Find a record by ID.
     */
    public static function find(string $id): array
    {
        $module = static::getModuleApiName();
        
        $response = static::makeRequest('get', "/{$module}/{$id}");

        if (isset($response['data'][0])) {
            return $response['data'][0];
        }

        throw ZohoApiException::recordNotFound($module, $id);
    }

    /**
     * Get all records with optional criteria.
     */
    public static function all(array $criteria = []): Collection
    {
        $module = static::getModuleApiName();
        
        $params = array_merge([
            'per_page' => config('zoho.pagination.per_page', 200),
        ], $criteria);

        $queryString = http_build_query($params);
        $response = static::makeRequest('get', "/{$module}?{$queryString}");

        $records = $response['data'] ?? [];
        
        return collect($records);
    }

    /**
     * Update a record.
     */
    public static function update(string $id, array $data): array
    {
        $module = static::getModuleApiName();
        
        $payload = [
            'data' => [
                array_merge(['id' => $id], $data)
            ],
        ];

        $response = static::makeRequest('put', "/{$module}", $payload);

        if (isset($response['data'][0])) {
            return $response['data'][0];
        }

        return $response;
    }

    /**
     * Delete a record.
     */
    public static function delete(string $id): bool
    {
        $module = static::getModuleApiName();
        
        $response = static::makeRequest('delete', "/{$module}/{$id}");

        return isset($response['data'][0]['status']) 
            && $response['data'][0]['status'] === 'success';
    }

    /**
     * Search records.
     */
    public static function search(string $criteria, array $params = []): Collection
    {
        $module = static::getModuleApiName();
        
        $queryParams = array_merge([
            'criteria' => $criteria,
            'per_page' => config('zoho.pagination.per_page', 200),
        ], $params);

        $queryString = http_build_query($queryParams);
        $response = static::makeRequest('get', "/{$module}/search?{$queryString}");

        $records = $response['data'] ?? [];
        
        return collect($records);
    }

    /**
     * Search by email (common use case).
     */
    public static function searchByEmail(string $email): Collection
    {
        return static::search("(Email:equals:{$email})");
    }

    /**
     * Search by phone (common use case).
     */
    public static function searchByPhone(string $phone): Collection
    {
        return static::search("(Phone:equals:{$phone})");
    }

    /**
     * Upsert a record (create or update).
     */
    public static function upsert(array $data, array $duplicateCheckFields = []): array
    {
        $module = static::getModuleApiName();
        
        $payload = [
            'data' => [$data],
        ];

        if (!empty($duplicateCheckFields)) {
            $payload['duplicate_check_fields'] = $duplicateCheckFields;
        }

        $response = static::makeRequest('post', "/{$module}/upsert", $payload);

        if (isset($response['data'][0])) {
            return $response['data'][0];
        }

        return $response;
    }

    /**
     * Get related records.
     */
    public static function getRelatedRecords(string $id, string $relatedModule): Collection
    {
        $module = static::getModuleApiName();
        
        $response = static::makeRequest('get', "/{$module}/{$id}/{$relatedModule}");

        $records = $response['data'] ?? [];
        
        return collect($records);
    }

    /**
     * Update multiple records.
     */
    public static function updateMultiple(array $records): array
    {
        $module = static::getModuleApiName();
        
        $payload = [
            'data' => $records,
        ];

        $response = static::makeRequest('put', "/{$module}", $payload);

        return $response['data'] ?? [];
    }

    /**
     * Delete multiple records.
     */
    public static function deleteMultiple(array $ids): array
    {
        $module = static::getModuleApiName();
        
        $idsString = implode(',', $ids);
        $response = static::makeRequest('delete', "/{$module}?ids={$idsString}");

        return $response['data'] ?? [];
    }

    /**
     * Get deleted records.
     */
    public static function getDeletedRecords(array $params = []): Collection
    {
        $module = static::getModuleApiName();
        
        $queryString = http_build_query($params);
        $response = static::makeRequest('get', "/{$module}/deleted?{$queryString}");

        $records = $response['data'] ?? [];
        
        return collect($records);
    }

    /**
     * Convert record (mainly for Leads).
     */
    public static function convert(string $id, array $data = []): array
    {
        $module = static::getModuleApiName();
        
        $payload = [
            'data' => [$data],
        ];

        $response = static::makeRequest('post', "/{$module}/{$id}/actions/convert", $payload);

        return $response;
    }

    /**
     * Get record count.
     */
    public static function count(array $criteria = []): int
    {
        $module = static::getModuleApiName();
        
        $queryString = !empty($criteria) ? '?' . http_build_query($criteria) : '';
        $response = static::makeRequest('get', "/{$module}/actions/count{$queryString}");

        return $response['count'] ?? 0;
    }

    /**
     * Clone a record.
     */
    public static function clone(string $id): array
    {
        $record = static::find($id);
        
        // Remove system fields
        $systemFields = ['id', 'Created_Time', 'Modified_Time', 'Created_By', 'Modified_By', 'Owner'];
        foreach ($systemFields as $field) {
            unset($record[$field]);
        }

        return static::create($record);
    }
}

