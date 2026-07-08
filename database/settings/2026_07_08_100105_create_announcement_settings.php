<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('announcement.enabled', false);
        $this->migrator->add('announcement.message', '');
        $this->migrator->add('announcement.starts_at', null);
        $this->migrator->add('announcement.ends_at', null);
        $this->migrator->add('announcement.dismissible', true);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('announcement.enabled');
        $this->migrator->deleteIfExists('announcement.message');
        $this->migrator->deleteIfExists('announcement.starts_at');
        $this->migrator->deleteIfExists('announcement.ends_at');
        $this->migrator->deleteIfExists('announcement.dismissible');
    }
};
