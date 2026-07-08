<?php

namespace App\Domain\Content\Models;

use App\Concerns\LogsAdminActivity;
use App\Domain\Content\Concerns\HasRevisions;
use App\Domain\Content\Concerns\Publishable;
use App\Domain\Content\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RuntimeException;

/**
 * @property PublishStatus $status
 */
class Testimonial extends Model
{
    use HasRevisions, LogsAdminActivity, Publishable;

    protected $fillable = [
        'quote',
        'attribution',
        'consent_on_file',
        'service_id',
        'status',
        'published_at',
        'first_published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PublishStatus::class,
            'published_at' => 'datetime',
            'first_published_at' => 'datetime',
            'consent_on_file' => 'boolean',
        ];
    }

    public static function booted(): void
    {
        static::saving(function (self $testimonial) {
            if ($testimonial->status === PublishStatus::Published && ! $testimonial->consent_on_file) {
                throw new RuntimeException(
                    'This testimonial cannot be published without consent on file. Tick "Consent on file" first.'
                );
            }
        });
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
