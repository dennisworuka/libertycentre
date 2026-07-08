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
     * Each item: ['question' => string, 'rating' => string]. This docblock
     * must never contain the standard PHPDoc type-tag as literal text (not
     * even in this description) — spatie/laravel-settings' cast resolver
     * naively regex-matches that tag anywhere in the comment at runtime,
     * and can't build a nested cast for a two-level generic array type,
     * which breaks settings resolution on every request. The PHPStan-only
     * tag below uses a different token the regex won't match, so it stays
     * invisible to spatie while still satisfying Larastan.
     *
     * @phpstan-var array<int, array{question: string, rating: string}>
     */
    public array $question_ratings;

    public static function group(): string
    {
        return 'cqc';
    }
}
