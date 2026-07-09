<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MenuItem extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'menu',
        'parent_id',
        'label',
        'type',
        'url',
        'page_slug',
        'opens_in_new_tab',
        'aria_label',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'opens_in_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('menus');
    }
}
