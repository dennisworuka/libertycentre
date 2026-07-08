<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('contact.phone', '');
        $this->migrator->add('contact.email_general', 'hello@libertycentre.example');
        $this->migrator->add('contact.email_referrals', 'referrals@libertycentre.example');
        $this->migrator->add('contact.email_careers', 'careers@libertycentre.example');
        $this->migrator->add('contact.office_hours', 'Monday to Friday, 9am to 5pm');
        $this->migrator->add('contact.map_lat', null);
        $this->migrator->add('contact.map_lng', null);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('contact.phone');
        $this->migrator->deleteIfExists('contact.email_general');
        $this->migrator->deleteIfExists('contact.email_referrals');
        $this->migrator->deleteIfExists('contact.email_careers');
        $this->migrator->deleteIfExists('contact.office_hours');
        $this->migrator->deleteIfExists('contact.map_lat');
        $this->migrator->deleteIfExists('contact.map_lng');
    }
};
