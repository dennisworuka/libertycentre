<?php

namespace App\Filament\Pages\Settings;

use App\Settings\MaintenanceSettings;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;

class MaintenanceSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $title = 'Maintenance';

    protected static ?string $navigationLabel = 'Maintenance';

    protected static string $settings = MaintenanceSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Toggle::make('enabled')
                ->label('Maintenance mode enabled'),

            TagsInput::make('allowed_ips')
                ->label('Allowed IP addresses')
                ->placeholder('Add an IP and press Enter'),
        ];
    }
}
