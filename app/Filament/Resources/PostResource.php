<?php

namespace App\Filament\Resources;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Post;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Support\ContentBlocks;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

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
                        ->disabled(fn (?Post $record): bool => $record?->wasEverPublished() ?? false)
                        ->dehydrated(),

                    TextInput::make('category')->maxLength(100),
                    TextInput::make('author_name')->label('Author')->maxLength(100),

                    Select::make('status')
                        ->options(collect(PublishStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                        ->required()
                        ->live(),

                    DateTimePicker::make('published_at'),
                ]),

            Section::make('Hero image')
                ->columns(2)
                ->schema([
                    SpatieMediaLibraryFileUpload::make('hero_image')
                        ->collection(Post::HERO_IMAGE_COLLECTION)
                        ->image()
                        ->columnSpanFull(),

                    TextInput::make('hero_image_alt')
                        ->label('Alt text')
                        ->helperText('Required before this post can be published.')
                        ->required(fn (Get $get): bool => $get('status') === PublishStatus::Published->value)
                        ->afterStateHydrated(function (TextInput $component, ?Post $record) {
                            $component->state($record?->getFirstMedia(Post::HERO_IMAGE_COLLECTION)?->getCustomProperty('alt'));
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
                TextColumn::make('title')->searchable(),
                TextColumn::make('category'),
                TextColumn::make('author_name')->label('Author'),
                BadgeColumn::make('status')->formatStateUsing(fn (PublishStatus $state) => $state->label()),
                TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
