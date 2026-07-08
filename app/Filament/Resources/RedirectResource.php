<?php

namespace App\Filament\Resources;

use App\Domain\Content\Models\Redirect;
use App\Filament\Resources\RedirectResource\Pages;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-top-right-on-square';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('from_path')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('The old path, e.g. /old-page.'),

            TextInput::make('to_path')
                ->required()
                ->maxLength(255)
                ->helperText('Where visitors should land instead, e.g. /new-page.'),

            Select::make('status_code')
                ->options([
                    301 => '301 — Permanent',
                    302 => '302 — Temporary',
                ])
                ->default(301)
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from_path')->searchable(),
                TextColumn::make('to_path')->searchable(),
                TextColumn::make('status_code'),
                TextColumn::make('hits')->sortable(),
            ])
            ->defaultSort('hits', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
