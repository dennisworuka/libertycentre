<?php

namespace App\Filament\Resources\ServicePageResource\Pages;

use App\Filament\Resources\ServicePageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServicePage extends EditRecord
{
    protected static string $resource = ServicePageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
