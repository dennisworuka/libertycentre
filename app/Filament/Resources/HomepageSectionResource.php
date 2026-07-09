<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSectionResource\Pages;
use App\Models\HomepageSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageSectionResource extends Resource
{
    protected static ?string $model = HomepageSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'Homepage';

    protected static ?string $navigationLabel = 'Homepage Layout';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('label')->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->required(),
            Forms\Components\Toggle::make('is_enabled'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('label'),
                Tables\Columns\TextColumn::make('key')->badge(),
                Tables\Columns\IconColumn::make('is_enabled')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListHomepageSections::route('/')];
    }
}
