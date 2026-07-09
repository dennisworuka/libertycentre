<?php

namespace App\Models;

use App\Support\ContentHeadingValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ServicePage extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'hero_image',
        'hero_image_alt',
        'blocks',
        'status',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'blocks' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (ServicePage $servicePage): void {
            ContentHeadingValidator::validate($servicePage->blocks ?? []);

            Validator::make($servicePage->attributesToArray(), [
                'hero_image_alt' => ['nullable', 'required_with:hero_image', 'string', 'min:3'],
            ])->validate();
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->useLogName('service_pages');
    }
}
