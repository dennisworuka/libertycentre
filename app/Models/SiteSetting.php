<?php

namespace App\Models;

use App\Rules\AccessibleContrast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class SiteSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'site_name',
        'strapline',
        'identity',
        'branding',
        'contact',
        'social_links',
        'cqc',
        'forms',
        'seo_analytics',
        'cookie_banner',
        'retention',
        'maintenance_enabled',
        'maintenance_message',
    ];

    protected $casts = [
        'identity' => 'array',
        'branding' => 'array',
        'contact' => 'array',
        'social_links' => 'array',
        'cqc' => 'array',
        'forms' => 'array',
        'seo_analytics' => 'array',
        'cookie_banner' => 'array',
        'retention' => 'array',
        'maintenance_enabled' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (SiteSetting $setting): void {
            $branding = $setting->branding ?? [];

            Validator::make($branding, [
                'primary' => ['nullable', new AccessibleContrast($branding['on_primary'] ?? '#FFFFFF')],
                'secondary_text' => ['nullable', new AccessibleContrast($branding['background'] ?? '#FFFFFF', 4.0)],
            ])->validate();
        });
    }

    public static function current(): self
    {
        return self::query()->firstOrCreate([], self::defaults());
    }

    public static function defaults(): array
    {
        return [
            'site_name' => 'Liberty Centre Limited',
            'strapline' => 'Empowering Lives. Supporting Independence. Inspiring Possibilities.',
            'branding' => [
                'primary' => '#B14040',
                'on_primary' => '#FFFFFF',
                'secondary' => '#77A244',
                'secondary_text' => '#5E8230',
                'accent' => '#C36844',
                'background' => '#FFFFFF',
                'font_scale' => 'base',
            ],
            'contact' => [
                'address' => '',
                'phone' => '',
                'email' => '',
                'office_hours' => '',
                'emergency' => '',
                'whatsapp' => '',
                'whatsapp_enabled' => false,
            ],
            'retention' => [
                'referrals_months' => 84,
                'enquiries_months' => 36,
                'applications_months' => 12,
                'talent_pool_months' => 24,
            ],
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('settings');
    }
}
