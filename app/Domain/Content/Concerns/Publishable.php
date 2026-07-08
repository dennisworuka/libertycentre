<?php

namespace App\Domain\Content\Concerns;

use App\Domain\Content\Enums\PublishStatus;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared draft/scheduled/published workflow. `first_published_at` is set
 * once and never cleared — it answers "has this ever gone live" (used to
 * lock the slug and gate redirect creation) independently of `published_at`,
 * which is the current/scheduled go-live time and may still move around.
 */
trait Publishable
{
    public static function bootPublishable(): void
    {
        static::saving(function ($model) {
            if ($model->status === PublishStatus::Published && empty($model->first_published_at)) {
                $model->first_published_at = $model->published_at ?? now();
            }
        });
    }

    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PublishStatus::Published)
            ->where('published_at', '<=', now());
    }

    public function wasEverPublished(): bool
    {
        return ! is_null($this->first_published_at);
    }
}
