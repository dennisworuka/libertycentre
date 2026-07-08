<?php

namespace App\Domain\Content\Concerns;

use App\Domain\Content\Models\Redirect;
use Illuminate\Support\Str;

/**
 * Auto-generates a unique slug from slugSourceValue() on create. Once a
 * record has ever been published (Publishable::wasEverPublished), changing
 * its slug automatically creates a 301 Redirect from the old public path to
 * the new one — the Filament resource additionally disables the field in
 * the UI at that point, but this is the real enforcement.
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug($model->slugSourceValue());
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('slug')) {
                $originalSlug = $model->getOriginal('slug');

                if ($originalSlug && $model->wasEverPublished()) {
                    Redirect::create([
                        'from_path' => $model->publicPath($originalSlug),
                        'to_path' => $model->publicPath($model->slug),
                        'status_code' => 301,
                    ]);
                }
            }
        });
    }

    protected function slugSourceValue(): string
    {
        return $this->title;
    }

    public function generateUniqueSlug(string $source): string
    {
        $base = Str::slug($source);
        $slug = $base;
        $suffix = 1;

        while (
            static::where('slug', $slug)
                ->when($this->exists, fn ($query) => $query->where($this->getKeyName(), '!=', $this->getKey()))
                ->exists()
        ) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * The public-facing URL for a given slug, used to build redirect
     * entries. Each model knows its own URL shape (e.g. /services/{slug}).
     */
    abstract public function publicPath(string $slug): string;
}
