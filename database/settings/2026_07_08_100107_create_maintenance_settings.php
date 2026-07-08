<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('maintenance.enabled', false);
        $this->migrator->add('maintenance.allowed_ips', []);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('maintenance.enabled');
        $this->migrator->deleteIfExists('maintenance.allowed_ips');
    }
};
