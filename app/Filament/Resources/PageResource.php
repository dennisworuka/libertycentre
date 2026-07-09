<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Page')->tabs([
                Forms\Components\Tabs\Tab::make('Content')->schema([
                    Forms\Components\TextInput::make('title')->required()->maxLength(255),
                    Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('template')
                        ->options(['default' => 'Default', 'landing' => 'Landing', 'easy_read' => 'Easy Read'])
                        ->default('default')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options(['draft' => 'Draft', 'published' => 'Published'])
                        ->default('draft')
                        ->required(),
                    Forms\Components\Repeater::make('blocks')
                        ->schema([
                            Forms\Components\Select::make('type')
                                ->options([
                                    'hero' => 'Hero',
                                    'rich_text' => 'Rich text',
                                    'image_text' => 'Image + text',
                                    'card_grid' => 'Card grid',
                                    'faq' => 'Accordion / FAQ',
                                    'cta' => 'CTA band',
                                    'embed' => 'Embed',
                                ])
                                ->required(),
                            Forms\Components\Select::make('heading_level')
                                ->options([1 => 'H1', 2 => 'H2', 3 => 'H3'])
                                ->required(),
                            Forms\Components\TextInput::make('heading')->required(),
                            Forms\Components\Textarea::make('body')->rows(4),
                        ])
                        ->defaultItems(1)
                        ->reorderable()
                        ->columnSpanFull(),
                ]),
                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title'),
                    Forms\Components\Textarea::make('meta_description')->rows(3),
                    Forms\Components\TextInput::make('og_image'),
                    Forms\Components\TextInput::make('canonical_url')->url(),
                    Forms\Components\Toggle::make('noindex'),
                    Forms\Components\DateTimePicker::make('published_at'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
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
