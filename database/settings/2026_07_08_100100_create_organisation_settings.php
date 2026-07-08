<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('organisation.site_name', 'Liberty Centre Limited');
        $this->migrator->add('organisation.logo_media_uuid', null);
        $this->migrator->add('organisation.favicon_media_uuid', null);
        $this->migrator->add('organisation.strapline', 'Specialist care for autism and learning disabilities across West Yorkshire.');
        $this->migrator->add('organisation.company_number', '');
        $this->migrator->add('organisation.registered_address', '');
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('organisation.site_name');
        $this->migrator->deleteIfExists('organisation.logo_media_uuid');
        $this->migrator->deleteIfExists('organisation.favicon_media_uuid');
        $this->migrator->deleteIfExists('organisation.strapline');
        $this->migrator->deleteIfExists('organisation.company_number');
        $this->migrator->deleteIfExists('organisation.registered_address');
    }
};
