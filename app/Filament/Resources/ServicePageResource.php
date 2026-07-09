<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicePageResource\Pages;
use App\Models\ServicePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServicePageResource extends Resource
{
    protected static ?string $model = ServicePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->maxLength(255),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('summary')->required()->rows(3)->columnSpanFull(),
            Forms\Components\TextInput::make('hero_image'),
            Forms\Components\TextInput::make('hero_image_alt'),
            Forms\Components\Select::make('status')->options(['draft' => 'Draft', 'published' => 'Published'])->default('draft')->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Repeater::make('blocks')
                ->schema([
                    Forms\Components\Select::make('type')->options([
                        'hero' => 'Hero',
                        'overview' => 'Overview',
                        'who_for' => 'Who it is for',
                        'support' => 'What support looks like',
                        'personalised' => 'How care is personalised',
                        'eligibility' => 'Eligibility and access',
                        'referral' => 'Referral process',
                        'benefits' => 'Benefits',
                        'involvement' => 'Family and professional involvement',
                        'testimonial' => 'Testimonial',
                        'faq' => 'FAQ',
                        'cta' => 'CTA',
                    ])->required(),
                    Forms\Components\Select::make('heading_level')->options([1 => 'H1', 2 => 'H2', 3 => 'H3'])->required(),
                    Forms\Components\TextInput::make('heading')->required(),
                    Forms\Components\Textarea::make('body')->rows(4),
                ])
                ->required()
                ->reorderable()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServicePages::route('/'),
            'create' => Pages\CreateServicePage::route('/create'),
            'edit' => Pages\EditServicePage::route('/{record}/edit'),
        ];
    }
}
