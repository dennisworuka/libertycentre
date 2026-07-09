<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TeamMember extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'role',
        'photo',
        'photo_alt',
        'bio',
        'dbs_checked',
        'leadership',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'dbs_checked' => 'boolean',
        'leadership' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderByDesc('leadership')->orderBy('sort_order');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->useLogName('team_members');
    }
}
