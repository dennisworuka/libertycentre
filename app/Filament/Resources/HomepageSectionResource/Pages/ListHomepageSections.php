<?php

namespace App\Filament\Resources\HomepageSectionResource\Pages;

use App\Filament\Resources\HomepageSectionResource;
use App\Models\HomepageSection;
use Filament\Resources\Pages\ListRecords;

class ListHomepageSections extends ListRecords
{
    protected static string $resource = HomepageSectionResource::class;

    public function mount(): void
    {
        HomepageSection::ensureDefaults();
        parent::mount();
    }
}
