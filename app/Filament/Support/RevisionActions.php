<?php

namespace App\Filament\Support;

use App\Domain\Content\Models\Revision;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class RevisionActions
{
    public static function restore(): Action
    {
        return Action::make('restoreRevision')
            ->label('Restore revision')
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('gray')
            ->form([
                Select::make('revision_id')
                    ->label('Revision')
                    ->options(fn ($record) => $record->revisions()
                        ->get()
                        ->mapWithKeys(fn (Revision $revision) => [
                            $revision->id => $revision->created_at->format('d M Y, H:i:s'),
                        ]))
                    ->required(),
            ])
            ->action(function (array $data, $record, EditRecord $livewire) {
                $revision = Revision::findOrFail($data['revision_id']);
                $record->restoreRevision($revision);

                $livewire->refreshFormData(array_keys($record->getAttributes()));

                Notification::make()
                    ->title('Revision restored')
                    ->success()
                    ->send();
            });
    }
}
