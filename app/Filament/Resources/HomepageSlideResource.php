<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageSlideResource\Pages;
use App\Models\HomepageSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomepageSlideResource extends Resource
{
    protected static ?string $model = HomepageSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Homepage';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('heading')->required(),
            Forms\Components\Textarea::make('subheading')->rows(3),
            Forms\Components\FileUpload::make('image_path')->directory('homepage-slides')->image(),
            Forms\Components\TextInput::make('image_alt')->required()->minLength(3),
            Forms\Components\TextInput::make('focal_point')->default('center center'),
            Forms\Components\TextInput::make('overlay_opacity')->numeric()->minValue(0)->maxValue(0.9)->default(0.55),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->default(true),
            Forms\Components\DateTimePicker::make('publish_from'),
            Forms\Components\DateTimePicker::make('publish_until'),
            Forms\Components\Repeater::make('buttons')
                ->schema([
                    Forms\Components\TextInput::make('label')->required(),
                    Forms\Components\TextInput::make('url')->required(),
                    Forms\Components\Select::make('style')->options(['primary' => 'Primary', 'secondary' => 'Secondary', 'cta' => 'CTA'])->default('primary'),
                ])
                ->maxItems(2)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('heading')->searchable(),
                Tables\Columns\TextColumn::make('image_alt')->limit(40),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomepageSlides::route('/'),
            'create' => Pages\CreateHomepageSlide::route('/create'),
            'edit' => Pages\EditHomepageSlide::route('/{record}/edit'),
        ];
    }
}
