<?php

namespace App\Domain\Content\Models;

use App\Concerns\LogsAdminActivity;
use App\Domain\Content\Concerns\HasPurifiedBlocks;
use App\Domain\Content\Concerns\HasRevisions;
use App\Domain\Content\Concerns\HasSlug;
use App\Domain\Content\Concerns\Publishable;
use App\Domain\Content\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property PublishStatus $status
 * @property array<int, array<string, mixed>> $body
 */
class Service extends Model implements HasMedia
{
    use HasPurifiedBlocks, HasRevisions, HasSlug, InteractsWithMedia, LogsAdminActivity, Publishable;

    public const CARD_IMAGE_COLLECTION = 'card_image';

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'summary',
        'body',
        'order',
        'status',
        'published_at',
        'first_published_at',
        'meta_title',
        'meta_description',
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
     * @return Attribute<array<int, array<string, mixed>>, array<int, array<string, mixed>>>
     */
    protected function body(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? json_decode($value, true) : [],
            set: fn (array $value) => json_encode($this->purifyBlocks($value)),
        );
    }

    public function publicPath(string $slug): string
    {
        return "/services/{$slug}";
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::CARD_IMAGE_COLLECTION)
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('480')->nonQueued()->width(480)->format('webp');
        $this->addMediaConversion('960')->nonQueued()->width(960)->format('webp');
        $this->addMediaConversion('1440')->nonQueued()->width(1440)->format('webp');
    }

    public function cardImageHasAltText(): bool
    {
        $media = $this->getFirstMedia(self::CARD_IMAGE_COLLECTION);

        return $media && filled($media->getCustomProperty('alt'));
    }
}
