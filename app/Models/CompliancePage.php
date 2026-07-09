<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CompliancePage extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'last_reviewed_at',
        'is_published',
    ];

    protected $casts = [
        'content' => 'array',
        'last_reviewed_at' => 'date',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->useLogName('compliance_pages');
    }
}
