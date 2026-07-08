<?php

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Domain\Content\Models\TeamMember;
use App\Filament\Resources\TeamMemberResource;
use App\Filament\Support\RevisionActions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            RevisionActions::restore(),
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        /** @var TeamMember $record */
        $record = $this->record;

        $alt = $this->data['photo_alt'] ?? null;
        $media = $record->getFirstMedia(TeamMember::PHOTO_COLLECTION);

        if ($media && filled($alt)) {
            $media->setCustomProperty('alt', $alt)->save();
        }
    }
}
