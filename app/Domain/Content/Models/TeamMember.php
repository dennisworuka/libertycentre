<?php

namespace App\Domain\Content\Models;

use App\Concerns\LogsAdminActivity;
use App\Domain\Content\Concerns\HasRevisions;
use App\Domain\Content\Concerns\Publishable;
use App\Domain\Content\Enums\PublishStatus;
use App\Support\Html\Purifier;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property PublishStatus $status
 */
class TeamMember extends Model implements HasMedia
{
    use HasRevisions, InteractsWithMedia, LogsAdminActivity, Publishable;

    public const PHOTO_COLLECTION = 'photo';

    protected $fillable = [
        'name',
        'role',
        'bio',
        'order',
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
            'order' => 'integer',
        ];
    }

    /**
     * @return Attribute<string|null, string|null>
     */
    protected function bio(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? Purifier::clean($value) : $value,
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PHOTO_COLLECTION)
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('480')->nonQueued()->width(480)->format('webp');
        $this->addMediaConversion('960')->nonQueued()->width(960)->format('webp');
    }

    public function photoHasAltText(): bool
    {
        $media = $this->getFirstMedia(self::PHOTO_COLLECTION);

        return $media && filled($media->getCustomProperty('alt'));
    }
}
