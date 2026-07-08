<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class NotificationSettings extends Settings
{
    public string $contact_recipient;

    public string $referral_recipient;

    public string $application_recipient;

    /** @var array<int, string> */
    public array $bcc_addresses;

    public static function group(): string
    {
        return 'notifications';
    }
}
