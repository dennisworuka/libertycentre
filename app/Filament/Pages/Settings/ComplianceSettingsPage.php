<?php

namespace App\Filament\Pages\Settings;

use App\Settings\ComplianceSettings;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ComplianceSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-scale';

    protected static ?string $title = 'Compliance';

    protected static ?string $navigationLabel = 'Compliance';

    protected static string $settings = ComplianceSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('cookie_banner_text')
                ->label('Cookie banner text')
                ->required()
                ->maxLength(1000),

            TextInput::make('retention_contact_months')
                ->label('Contact submission retention (months)')
                ->numeric()
                ->minValue(1)
                ->required(),

            TextInput::make('retention_referral_months')
                ->label('Referral submission retention (months)')
                ->numeric()
                ->minValue(1)
                ->required(),

            TextInput::make('retention_cv_months')
                ->label('CV / application retention (months)')
                ->numeric()
                ->minValue(1)
                ->required(),

            Toggle::make('analytics_enabled')
                ->label('Analytics enabled (consent-gated)'),
        ];
    }
}
