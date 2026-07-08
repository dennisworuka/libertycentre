<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('cqc.rating_label', 'Good');
        $this->migrator->add('cqc.rating_date', '2026-01-01');
        $this->migrator->add('cqc.badge_enabled', true);
        $this->migrator->add('cqc.report_url', 'https://www.cqc.org.uk/');
        $this->migrator->add('cqc.question_ratings', [
            ['question' => 'Is it safe?', 'rating' => 'Good'],
            ['question' => 'Is it effective?', 'rating' => 'Good'],
            ['question' => 'Is it caring?', 'rating' => 'Good'],
            ['question' => 'Is it responsive to people\'s needs?', 'rating' => 'Good'],
            ['question' => 'Is it well-led?', 'rating' => 'Good'],
        ]);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('cqc.rating_label');
        $this->migrator->deleteIfExists('cqc.rating_date');
        $this->migrator->deleteIfExists('cqc.badge_enabled');
        $this->migrator->deleteIfExists('cqc.report_url');
        $this->migrator->deleteIfExists('cqc.question_ratings');
    }
};
