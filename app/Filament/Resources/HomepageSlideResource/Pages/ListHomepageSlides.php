<?php

namespace App\Filament\Resources\HomepageSlideResource\Pages;

use App\Filament\Resources\HomepageSlideResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomepageSlides extends ListRecords
{
    protected static string $resource = HomepageSlideResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
