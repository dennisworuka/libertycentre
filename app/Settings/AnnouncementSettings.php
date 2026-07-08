<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AnnouncementSettings extends Settings
{
    public bool $enabled;

    public string $message;

    public ?string $starts_at;

    public ?string $ends_at;

    public bool $dismissible;

    public static function group(): string
    {
        return 'announcement';
    }
}
