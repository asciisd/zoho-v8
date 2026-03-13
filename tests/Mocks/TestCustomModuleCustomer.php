<?php

namespace Asciisd\ZohoV8\Tests\Mocks;

use Asciisd\ZohoV8\Traits\SyncsWithZoho;
use Illuminate\Database\Eloquent\Model;

class TestCustomModuleCustomer extends Model
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
        return 'Property_Listings';
    }

    public function getZohoModelClass(): ?string
    {
        return ZohoPropertyListing::class;
    }

    public function getZohoFieldMapping(): array
    {
        return [
            'name' => 'Listing_Name',
            'email' => 'Agent_Email',
            'company' => 'Agency',
        ];
    }
}
