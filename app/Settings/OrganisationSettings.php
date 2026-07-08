<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class OrganisationSettings extends Settings
{
    public string $site_name;

    public ?string $logo_media_uuid;

    public ?string $favicon_media_uuid;

    public string $strapline;

    public string $company_number;

    public string $registered_address;

    public static function group(): string
    {
        return 'organisation';
    }
}
