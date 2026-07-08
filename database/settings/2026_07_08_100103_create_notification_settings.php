<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('notifications.contact_recipient', 'hello@libertycentre.example');
        $this->migrator->add('notifications.referral_recipient', 'referrals@libertycentre.example');
        $this->migrator->add('notifications.application_recipient', 'careers@libertycentre.example');
        $this->migrator->add('notifications.bcc_addresses', []);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('notifications.contact_recipient');
        $this->migrator->deleteIfExists('notifications.referral_recipient');
        $this->migrator->deleteIfExists('notifications.application_recipient');
        $this->migrator->deleteIfExists('notifications.bcc_addresses');
    }
};
