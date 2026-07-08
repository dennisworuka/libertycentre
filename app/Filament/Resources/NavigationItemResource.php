<?php

namespace App\Filament\Resources;

use App\Domain\Content\Models\NavigationItem;
use App\Filament\Resources\NavigationItemResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('label')->required()->maxLength(255),
            TextInput::make('url')->required()->maxLength(255),

            Select::make('location')
                ->options([
                    NavigationItem::LOCATION_HEADER => 'Header',
                    NavigationItem::LOCATION_FOOTER => 'Footer',
                ])
                ->required()
                ->live(),

            Select::make('parent_id')
                ->label('Parent (top-level items only)')
                ->options(fn (Get $get) => NavigationItem::query()
                    ->whereNull('parent_id')
                    ->where('location', $get('location'))
                    ->pluck('label', 'id'))
                ->searchable(),

            TextInput::make('order')->numeric()->default(0),

            Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->searchable(),
                TextColumn::make('url'),
                TextColumn::make('parent.label')->label('Parent')->placeholder('—'),
                TextColumn::make('location')->badge(),
                TextColumn::make('order')->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                SelectFilter::make('location')->options([
                    NavigationItem::LOCATION_HEADER => 'Header',
                    NavigationItem::LOCATION_FOOTER => 'Footer',
                ]),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationItems::route('/'),
            'create' => Pages\CreateNavigationItem::route('/create'),
            'edit' => Pages\EditNavigationItem::route('/{record}/edit'),
        ];
    }
}
