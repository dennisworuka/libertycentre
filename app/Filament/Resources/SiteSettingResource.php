<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Site Settings';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Settings')->tabs([
                Forms\Components\Tabs\Tab::make('Identity')->schema([
                    Forms\Components\TextInput::make('site_name')->required(),
                    Forms\Components\TextInput::make('strapline'),
                    Forms\Components\KeyValue::make('identity'),
                ]),
                Forms\Components\Tabs\Tab::make('Branding')->schema([
                    Forms\Components\KeyValue::make('branding')
                        ->helperText('Defaults include the official palette. Saving validates key AA contrast combinations.'),
                ]),
                Forms\Components\Tabs\Tab::make('Contact')->schema([
                    Forms\Components\KeyValue::make('contact'),
                    Forms\Components\KeyValue::make('social_links'),
                    Forms\Components\KeyValue::make('cqc'),
                ]),
                Forms\Components\Tabs\Tab::make('Forms, SEO & Cookies')->schema([
                    Forms\Components\KeyValue::make('forms'),
                    Forms\Components\KeyValue::make('seo_analytics'),
                    Forms\Components\KeyValue::make('cookie_banner'),
                    Forms\Components\KeyValue::make('retention'),
                ]),
                Forms\Components\Tabs\Tab::make('Maintenance')->schema([
                    Forms\Components\Toggle::make('maintenance_enabled'),
                    Forms\Components\Textarea::make('maintenance_message')->rows(4),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site_name'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime(),
                Tables\Columns\IconColumn::make('maintenance_enabled')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
