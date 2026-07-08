<?php

namespace App\Domain\Content\Models;

use App\Concerns\LogsAdminActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RuntimeException;

class NavigationItem extends Model
{
    use LogsAdminActivity;

    public const LOCATION_HEADER = 'header';

    public const LOCATION_FOOTER = 'footer';

    protected $fillable = [
        'label',
        'url',
        'parent_id',
        'location',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public static function booted(): void
    {
        static::saving(function (self $item) {
            if (! $item->parent_id) {
                return;
            }

            $parentHasItsOwnParent = self::whereKey($item->parent_id)->value('parent_id');

            if ($parentHasItsOwnParent) {
                throw new RuntimeException('Navigation only supports two levels — a child item cannot itself have a parent that is a child.');
            }
        });
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }
}
