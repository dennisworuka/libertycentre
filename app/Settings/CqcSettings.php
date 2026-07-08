<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CqcSettings extends Settings
{
    public string $rating_label;

    public ?string $rating_date;

    public bool $badge_enabled;

    public string $report_url;

    /**
     * Each item: ['question' => string, 'rating' => string]. No plain @var
     * generic here — spatie/laravel-settings' cast resolver reads @var at
     * runtime and can't build a nested cast for a two-level generic array
     * type. @phpstan-var is a PHPStan-only tag spatie's regex doesn't match,
     * so this is invisible to it while still satisfying Larastan.
     *
     * @phpstan-var array<int, array{question: string, rating: string}>
     */
    public array $question_ratings;

    public static function group(): string
    {
        return 'cqc';
    }
}
