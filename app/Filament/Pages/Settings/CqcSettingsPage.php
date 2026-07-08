<?php

namespace App\Filament\Pages\Settings;

use App\Settings\CqcSettings;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class CqcSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $title = 'CQC & Quality';

    protected static ?string $navigationLabel = 'CQC & Quality';

    protected static string $settings = CqcSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('rating_label')
                ->label('Overall rating')
                ->required()
                ->maxLength(50),

            DatePicker::make('rating_date')
                ->label('Rating date'),

            Toggle::make('badge_enabled')
                ->label('Show CQC badge on the site'),

            TextInput::make('report_url')
                ->label('Official CQC report URL')
                ->url()
                ->required(),

            Repeater::make('question_ratings')
                ->label('Key question ratings')
                ->schema([
                    TextInput::make('question')->required()->maxLength(255),
                    TextInput::make('rating')->required()->maxLength(50),
                ])
                ->columns(2)
                ->reorderable(false),
        ];
    }
}
