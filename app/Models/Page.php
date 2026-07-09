<?php

namespace App\Models;

use App\Support\ContentHeadingValidator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'template',
        'status',
        'blocks',
        'meta_title',
        'meta_description',
        'og_image',
        'canonical_url',
        'noindex',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'blocks' => 'array',
        'noindex' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Page $page): void {
            ContentHeadingValidator::validate($page->blocks ?? []);
        });

        static::saved(function (Page $page): void {
            $page->revisions()->create([
                'snapshot' => $page->only([
                    'title',
                    'slug',
                    'template',
                    'status',
                    'blocks',
                    'meta_title',
                    'meta_description',
                    'og_image',
                    'canonical_url',
                    'noindex',
                    'published_at',
                ]),
                'created_by' => auth()->id(),
            ]);
        });
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(PageRevision::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->useLogName('pages');
    }
}
