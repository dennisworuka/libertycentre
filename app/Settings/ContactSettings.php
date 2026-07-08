<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ContactSettings extends Settings
{
    public string $phone;

    public string $email_general;

    public string $email_referrals;

    public string $email_careers;

    public string $office_hours;

    public ?float $map_lat;

    public ?float $map_lng;

    public static function group(): string
    {
        return 'contact';
    }
}
