<?php

namespace App\Filament\Pages\Settings;

use App\Settings\ContactSettings;
use Filament\Forms\Components\TextInput;

class ContactSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $title = 'Contact';

    protected static ?string $navigationLabel = 'Contact';

    protected static string $settings = ContactSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('phone')
                ->label('Phone number')
                ->tel()
                ->required(),

            TextInput::make('email_general')
                ->label('General enquiries email')
                ->email()
                ->required(),

            TextInput::make('email_referrals')
                ->label('Referrals email')
                ->email()
                ->required(),

            TextInput::make('email_careers')
                ->label('Careers email')
                ->email()
                ->required(),

            TextInput::make('office_hours')
                ->label('Office hours')
                ->required()
                ->maxLength(255),

            TextInput::make('map_lat')
                ->label('Map latitude')
                ->numeric(),

            TextInput::make('map_lng')
                ->label('Map longitude')
                ->numeric(),
        ];
    }
}
