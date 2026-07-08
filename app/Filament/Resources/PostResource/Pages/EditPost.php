<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Domain\Content\Models\Post;
use App\Filament\Resources\PostResource;
use App\Filament\Support\RevisionActions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            RevisionActions::restore(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
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
