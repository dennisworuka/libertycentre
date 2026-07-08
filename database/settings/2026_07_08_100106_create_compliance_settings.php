<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('compliance.cookie_banner_text', 'We use essential cookies to run this site. With your consent, we also use analytics cookies to understand how it is used.');
        $this->migrator->add('compliance.retention_contact_months', 12);
        $this->migrator->add('compliance.retention_referral_months', 6);
        $this->migrator->add('compliance.retention_cv_months', 6);
        $this->migrator->add('compliance.analytics_enabled', false);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('compliance.cookie_banner_text');
        $this->migrator->deleteIfExists('compliance.retention_contact_months');
        $this->migrator->deleteIfExists('compliance.retention_referral_months');
        $this->migrator->deleteIfExists('compliance.retention_cv_months');
        $this->migrator->deleteIfExists('compliance.analytics_enabled');
    }
};
