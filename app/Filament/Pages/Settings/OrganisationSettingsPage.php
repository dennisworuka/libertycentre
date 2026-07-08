<?php

namespace App\Filament\Pages\Settings;

use App\Settings\OrganisationSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class OrganisationSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $title = 'Organisation';

    protected static ?string $navigationLabel = 'Organisation';

    protected static string $settings = OrganisationSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name')
                ->label('Site name')
                ->required()
                ->maxLength(255),

            FileUpload::make('logo_media_uuid')
                ->label('Logo')
                ->image()
                ->directory('organisation'),

            FileUpload::make('favicon_media_uuid')
                ->label('Favicon')
                ->image()
                ->directory('organisation'),

            TextInput::make('strapline')
                ->label('Strapline')
                ->required()
                ->maxLength(255),

            TextInput::make('company_number')
                ->label('Company number')
                ->maxLength(50),

            TextInput::make('registered_address')
                ->label('Registered address')
                ->maxLength(255),
        ];
    }
}
