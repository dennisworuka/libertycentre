<?php

namespace App\Filament\Resources;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Service;
use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Support\ContentBlocks;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

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
                        ->disabled(fn (?Service $record): bool => $record?->wasEverPublished() ?? false)
                        ->dehydrated(),

                    TextInput::make('icon')
                        ->helperText('A Heroicon name, e.g. heroicon-o-heart.')
                        ->maxLength(100),

                    TextInput::make('order')->numeric()->default(0),

                    Select::make('status')
                        ->options(collect(PublishStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                        ->required()
                        ->live(),

                    DateTimePicker::make('published_at'),
                ]),

            Textarea::make('summary')->required()->maxLength(500)->columnSpanFull(),

            Section::make('Card image')
                ->columns(2)
                ->schema([
                    SpatieMediaLibraryFileUpload::make('card_image')
                        ->collection(Service::CARD_IMAGE_COLLECTION)
                        ->image()
                        ->columnSpanFull(),

                    TextInput::make('card_image_alt')
                        ->label('Alt text')
                        ->helperText('Required before this service can be published.')
                        ->required(fn (Get $get): bool => $get('status') === PublishStatus::Published->value)
                        ->afterStateHydrated(function (TextInput $component, ?Service $record) {
                            $component->state($record?->getFirstMedia(Service::CARD_IMAGE_COLLECTION)?->getCustomProperty('alt'));
                        }),
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
                TextColumn::make('order')->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug')->searchable(),
                BadgeColumn::make('status')->formatStateUsing(fn (PublishStatus $state) => $state->label()),
                TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
