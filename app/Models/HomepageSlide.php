<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class HomepageSlide extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'heading',
        'subheading',
        'image_path',
        'image_alt',
        'buttons',
        'overlay_opacity',
        'focal_point',
        'sort_order',
        'is_published',
        'publish_from',
        'publish_until',
    ];

    protected $casts = [
        'buttons' => 'array',
        'overlay_opacity' => 'float',
        'is_published' => 'boolean',
        'publish_from' => 'datetime',
        'publish_until' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (HomepageSlide $slide): void {
            Validator::make($slide->attributesToArray(), [
                'image_alt' => ['required', 'string', 'min:3'],
            ])->validate();
        });
    }

    public function scopeVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(fn ($query) => $query->whereNull('publish_from')->orWhere('publish_from', '<=', now()))
            ->where(fn ($query) => $query->whereNull('publish_until')->orWhere('publish_until', '>=', now()))
            ->orderBy('sort_order');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->useLogName('homepage_slides');
    }
}
