<?php

namespace Asciisd\ZohoV8\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Asciisd\ZohoV8\Models\ZohoContact contacts()
 * @method static \Asciisd\ZohoV8\Models\ZohoAccount accounts()
 * @method static \Asciisd\ZohoV8\Models\ZohoLead leads()
 * @method static \Asciisd\ZohoV8\Models\ZohoDeal deals()
 * @method static \Asciisd\ZohoV8\Models\ZohoTask tasks()
 * @method static \Asciisd\ZohoV8\Models\ZohoEvent events()
 * @method static \Asciisd\ZohoV8\Models\ZohoCall calls()
 * @method static \Asciisd\ZohoV8\Models\ZohoNote notes()
 * @method static \Asciisd\ZohoV8\Models\ZohoProduct products()
 * @method static \Asciisd\ZohoV8\Models\ZohoInvoice invoices()
 *
 * @see \Asciisd\ZohoV8\ZohoClient
 */
class Zoho extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'zoho';
    }
}
