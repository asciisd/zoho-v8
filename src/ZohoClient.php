<?php

namespace Asciisd\ZohoV8;

use Asciisd\ZohoV8\Models\ZohoAccount;
use Asciisd\ZohoV8\Models\ZohoCall;
use Asciisd\ZohoV8\Models\ZohoContact;
use Asciisd\ZohoV8\Models\ZohoDeal;
use Asciisd\ZohoV8\Models\ZohoEvent;
use Asciisd\ZohoV8\Models\ZohoInvoice;
use Asciisd\ZohoV8\Models\ZohoLead;
use Asciisd\ZohoV8\Models\ZohoNote;
use Asciisd\ZohoV8\Models\ZohoProduct;
use Asciisd\ZohoV8\Models\ZohoTask;

class ZohoClient
{
    /**
     * Get Contacts module instance.
     */
    public function contacts(): ZohoContact
    {
        return new ZohoContact;
    }

    /**
     * Get Accounts module instance.
     */
    public function accounts(): ZohoAccount
    {
        return new ZohoAccount;
    }

    /**
     * Get Leads module instance.
     */
    public function leads(): ZohoLead
    {
        return new ZohoLead;
    }

    /**
     * Get Deals module instance.
     */
    public function deals(): ZohoDeal
    {
        return new ZohoDeal;
    }

    /**
     * Get Tasks module instance.
     */
    public function tasks(): ZohoTask
    {
        return new ZohoTask;
    }

    /**
     * Get Events module instance.
     */
    public function events(): ZohoEvent
    {
        return new ZohoEvent;
    }

    /**
     * Get Calls module instance.
     */
    public function calls(): ZohoCall
    {
        return new ZohoCall;
    }

    /**
     * Get Notes module instance.
     */
    public function notes(): ZohoNote
    {
        return new ZohoNote;
    }

    /**
     * Get Products module instance.
     */
    public function products(): ZohoProduct
    {
        return new ZohoProduct;
    }

    /**
     * Get Invoices module instance.
     */
    public function invoices(): ZohoInvoice
    {
        return new ZohoInvoice;
    }
}
