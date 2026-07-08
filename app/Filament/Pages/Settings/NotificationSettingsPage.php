<?php

namespace App\Filament\Pages\Settings;

use App\Settings\NotificationSettings;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;

class NotificationSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?string $title = 'Notifications';

    protected static ?string $navigationLabel = 'Notifications';

    protected static string $settings = NotificationSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('contact_recipient')
                ->label('Contact form recipient')
                ->email()
                ->required(),

            TextInput::make('referral_recipient')
                ->label('Referral form recipient')
                ->email()
                ->required(),

            TextInput::make('application_recipient')
                ->label('Job application recipient')
                ->email()
                ->required(),

            TagsInput::make('bcc_addresses')
                ->label('BCC addresses')
                ->placeholder('Add an email and press Enter'),
        ];
    }
}
