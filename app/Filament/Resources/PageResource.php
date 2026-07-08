<?php

namespace App\Filament\Resources;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Page;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Support\ContentBlocks;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true),

                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->disabled(fn (?Page $record): bool => $record?->wasEverPublished() ?? false)
                        ->dehydrated(),

                    Select::make('status')
                        ->options(collect(PublishStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                        ->required()
                        ->live(),

                    DateTimePicker::make('published_at'),
                ]),

            Section::make('SEO')
                ->columns(2)
                ->schema([
                    TextInput::make('meta_title')->maxLength(255),
                    TextInput::make('meta_description')->maxLength(320),
                ]),

            Section::make('Content')
                ->schema([
                    ContentBlocks::make('body'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug')->searchable(),
                BadgeColumn::make('status')->formatStateUsing(fn (PublishStatus $state) => $state->label()),
                TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->defaultSort('title');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
