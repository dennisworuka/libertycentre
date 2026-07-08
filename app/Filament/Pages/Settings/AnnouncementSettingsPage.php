<?php

namespace App\Filament\Pages\Settings;

use App\Settings\AnnouncementSettings;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class AnnouncementSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $title = 'Announcement';

    protected static ?string $navigationLabel = 'Announcement';

    protected static string $settings = AnnouncementSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Toggle::make('enabled')
                ->label('Show site-wide banner'),

            Textarea::make('message')
                ->label('Message')
                ->maxLength(500),

            DateTimePicker::make('starts_at')
                ->label('Starts at'),

            DateTimePicker::make('ends_at')
                ->label('Ends at'),

            Toggle::make('dismissible')
                ->label('Visitors can dismiss it'),
        ];
    }
}
