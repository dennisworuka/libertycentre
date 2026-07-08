<?php

namespace App\Domain\Content\Concerns;

use App\Domain\Content\Models\Revision;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRevisions
{
    public static function bootHasRevisions(): void
    {
        static::saved(function ($model) {
            $model->revisions()->create([
                'user_id' => auth()->id(),
                'payload' => $model->attributesToArray(),
            ]);
        });
    }

    /**
     * @return MorphMany<Revision, $this>
     */
    public function revisions(): MorphMany
    {
        // Ordered by id, not created_at: two revisions saved within the
        // same second would otherwise tie and sort unpredictably.
        return $this->morphMany(Revision::class, 'revisionable')->latest('id');
    }

    public function restoreRevision(Revision $revision): static
    {
        /** @var array<string, mixed> $payload */
        $payload = collect($revision->payload)
            ->except([$this->getKeyName(), 'created_at', 'updated_at'])
            ->all();

        $this->forceFill($payload)->save();

        return $this;
    }
}
