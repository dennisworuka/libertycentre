<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MediaAsset extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'folder',
        'name',
        'file_path',
        'mime_type',
        'size',
        'alt_text',
        'conversions',
        'usage',
        'uploaded_by',
    ];

    protected $casts = [
        'conversions' => 'array',
        'usage' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (MediaAsset $asset): void {
            Validator::make($asset->attributesToArray(), [
                'alt_text' => ['required', 'string', 'min:3'],
            ])->validate();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('media');
    }
}
