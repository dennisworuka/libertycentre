<?php

namespace App\Filament\Resources\HomepageSlideResource\Pages;

use App\Filament\Resources\HomepageSlideResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomepageSlide extends EditRecord
{
    protected static string $resource = HomepageSlideResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
