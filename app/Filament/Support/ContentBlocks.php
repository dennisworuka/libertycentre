<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

/**
 * The block schema shared by every block-based body field (Page, Service,
 * Post). Rich text content is purified server-side by
 * App\Domain\Content\Concerns\HasPurifiedBlocks when the model saves — this
 * class only defines the editing UI, not the sanitisation.
 */
class ContentBlocks
{
    public static function make(string $fieldName = 'body'): Builder
    {
        return Builder::make($fieldName)
            ->blocks([
                Block::make('heading')
                    ->schema([
                        TextInput::make('text')->required()->maxLength(255),
                        Select::make('level')
                            ->options(['h2' => 'Heading 2', 'h3' => 'Heading 3'])
                            ->default('h2')
                            ->required(),
                    ]),

                Block::make('rich_text')
                    ->schema([
                        RichEditor::make('content')->required(),
                    ]),

                Block::make('image')
                    ->schema([
                        FileUpload::make('path')
                            ->image()
                            ->directory('content-images')
                            ->required(),
                        TextInput::make('alt')
                            ->label('Alt text')
                            ->required()
                            ->helperText('Required — describes the image for screen readers and search engines.'),
                        TextInput::make('caption')->maxLength(255),
                    ]),

                Block::make('feature_list')
                    ->schema([
                        TextInput::make('title')->maxLength(255),
                        Repeater::make('items')
                            ->schema([
                                TextInput::make('icon')->maxLength(100),
                                TextInput::make('title')->required()->maxLength(255),
                                Textarea::make('description')->required(),
                            ])
                            ->required(),
                    ]),

                Block::make('steps')
                    ->schema([
                        TextInput::make('title')->maxLength(255),
                        Repeater::make('items')
                            ->schema([
                                TextInput::make('title')->required()->maxLength(255),
                                Textarea::make('description')->required(),
                            ])
                            ->required(),
                    ]),

                Block::make('faq')
                    ->schema([
                        Repeater::make('items')
                            ->schema([
                                TextInput::make('question')->required()->maxLength(255),
                                Textarea::make('answer')->required(),
                            ])
                            ->required(),
                    ]),

                Block::make('quote')
                    ->schema([
                        Textarea::make('text')->required(),
                        TextInput::make('attribution')->maxLength(255),
                    ]),

                Block::make('cta')
                    ->schema([
                        TextInput::make('heading')->maxLength(255),
                        Textarea::make('text'),
                        TextInput::make('button_label')->required()->maxLength(100),
                        TextInput::make('button_url')->required()->url(),
                    ]),

                Block::make('two_column')
                    ->schema([
                        RichEditor::make('left')->required(),
                        RichEditor::make('right')->required(),
                    ]),
            ])
            ->collapsible()
            ->blockNumbers(false);
    }
}
