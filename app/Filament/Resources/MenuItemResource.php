<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('menu')
                ->options(['header' => 'Header', 'footer' => 'Footer'])
                ->required(),
            Forms\Components\Select::make('parent_id')
                ->relationship('parent', 'label')
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('label')->required()->maxLength(255),
            Forms\Components\Select::make('type')
                ->options(['internal' => 'Internal page', 'external' => 'External URL'])
                ->required()
                ->live(),
            Forms\Components\TextInput::make('page_slug')
                ->label('Internal page slug')
                ->visible(fn (Forms\Get $get): bool => $get('type') === 'internal'),
            Forms\Components\TextInput::make('url')
                ->url()
                ->visible(fn (Forms\Get $get): bool => $get('type') === 'external'),
            Forms\Components\Toggle::make('opens_in_new_tab'),
            Forms\Components\TextInput::make('aria_label')->maxLength(255),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('menu')->badge()->sortable(),
                Tables\Columns\TextColumn::make('label')->searchable(),
                Tables\Columns\TextColumn::make('parent.label')->label('Parent'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
