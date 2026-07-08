<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SocialSeoSettings extends Settings
{
    public ?string $facebook_url;

    public ?string $twitter_url;

    public ?string $linkedin_url;

    public ?string $instagram_url;

    public string $default_meta_title;

    public string $default_meta_description;

    public ?string $default_share_image_media_uuid;

    public static function group(): string
    {
        return 'social_seo';
    }
}
