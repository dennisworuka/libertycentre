<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CqcSettings extends Settings
{
    public string $rating_label;

    public ?string $rating_date;

    public bool $badge_enabled;

    public string $report_url;

    /** @var array<int, array{question: string, rating: string}> */
    public array $question_ratings;

    public static function group(): string
    {
        return 'cqc';
    }
}
