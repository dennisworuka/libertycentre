<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Domain\Content\Models\Post;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function afterCreate(): void
    {
        /** @var Post $record */
        $record = $this->record;

        $alt = $this->data['hero_image_alt'] ?? null;
        $media = $record->getFirstMedia(Post::HERO_IMAGE_COLLECTION);

        if ($media && filled($alt)) {
            $media->setCustomProperty('alt', $alt)->save();
        }
    }
}
