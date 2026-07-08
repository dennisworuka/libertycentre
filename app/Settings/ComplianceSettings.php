<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ComplianceSettings extends Settings
{
    public string $cookie_banner_text;

    public int $retention_contact_months;

    public int $retention_referral_months;

    public int $retention_cv_months;

    public bool $analytics_enabled;

    public static function group(): string
    {
        return 'compliance';
    }
}
