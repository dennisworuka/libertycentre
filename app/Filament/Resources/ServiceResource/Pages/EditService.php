<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Domain\Content\Models\Service;
use App\Filament\Resources\ServiceResource;
use App\Filament\Support\RevisionActions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            RevisionActions::restore(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        /** @var Service $record */
        $record = $this->record;

        $alt = $this->data['card_image_alt'] ?? null;
        $media = $record->getFirstMedia(Service::CARD_IMAGE_COLLECTION);

        if ($media && filled($alt)) {
            $media->setCustomProperty('alt', $alt)->save();
        }
    }
}
