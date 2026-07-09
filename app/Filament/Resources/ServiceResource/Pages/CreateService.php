<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Domain\Content\Models\Service;
use App\Filament\Resources\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function afterCreate(): void
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
