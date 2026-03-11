<?php

namespace Asciisd\ZohoV8\Tests\Mocks;

use Asciisd\ZohoV8\Traits\SyncsWithZoho;
use Illuminate\Database\Eloquent\Model;

class TestCustomerNoMapping extends Model
{
    use SyncsWithZoho;

    protected $table = 'test_customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
    ];

    public function getZohoModule(): string
    {
        return 'Contacts';
    }
}
