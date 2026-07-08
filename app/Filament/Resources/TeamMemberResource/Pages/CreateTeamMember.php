<?php

namespace App\Filament\Resources\TeamMemberResource\Pages;

use App\Domain\Content\Models\TeamMember;
use App\Filament\Resources\TeamMemberResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeamMember extends CreateRecord
{
    protected static string $resource = TeamMemberResource::class;

    protected function afterCreate(): void
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
