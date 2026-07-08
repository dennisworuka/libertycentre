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

/**
 * @property PublishStatus $status
 * @property array<int, array<string, mixed>> $body
 */
class Page extends Model
{
    use HasPurifiedBlocks, HasRevisions, HasSlug, LogsAdminActivity, Publishable;

    protected $fillable = [
        'title',
        'slug',
        'body',
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
        return "/{$slug}";
    }
}
