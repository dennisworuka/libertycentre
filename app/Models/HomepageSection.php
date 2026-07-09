<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    public const DEFAULTS = [
        'hero_slider' => 'Hero slider',
        'intro_strip' => 'Intro strip',
        'service_links' => 'Quick service links',
        'referral_cta' => 'Make a referral CTA',
        'stats_strip' => 'Stats strip',
        'cqc_quality' => 'CQC and quality assurance',
        'testimonials' => 'Testimonials carousel',
        'latest_news_events' => 'Latest news and events',
        'coverage_map' => 'Coverage map',
        'newsletter_signup' => 'Newsletter signup',
        'urgent_contact' => 'Emergency contact strip',
    ];

    protected $fillable = ['key', 'label', 'sort_order', 'is_enabled'];

    protected $casts = ['is_enabled' => 'boolean'];

    public static function ensureDefaults(): void
    {
        foreach (array_values(self::DEFAULTS) as $index => $label) {
            $key = array_keys(self::DEFAULTS)[$index];

            self::query()->firstOrCreate(
                ['key' => $key],
                ['label' => $label, 'sort_order' => $index + 1, 'is_enabled' => true]
            );
        }
    }
}
