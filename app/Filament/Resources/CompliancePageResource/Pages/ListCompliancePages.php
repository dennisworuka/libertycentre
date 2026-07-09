<?php

namespace App\Filament\Resources\CompliancePageResource\Pages;

use App\Filament\Resources\CompliancePageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompliancePages extends ListRecords
{
    protected static string $resource = CompliancePageResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
