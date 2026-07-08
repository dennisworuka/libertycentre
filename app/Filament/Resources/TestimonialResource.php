<?php

namespace App\Filament\Resources;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\Testimonial;
use App\Filament\Resources\TestimonialResource\Pages;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Textarea::make('quote')->required()->maxLength(1000)->columnSpanFull(),

            TextInput::make('attribution')->required()->maxLength(255),

            Select::make('service_id')
                ->label('Related service')
                ->relationship('service', 'title')
                ->searchable(),

            Toggle::make('consent_on_file')
                ->label('Consent on file')
                ->helperText('Required before this testimonial can be published.')
                ->live(),

            Select::make('status')
                ->options(collect(PublishStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                ->required()
                ->live()
                ->rules([
                    fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                        if ($value === PublishStatus::Published->value && ! $get('consent_on_file')) {
                            $fail('This testimonial cannot be published without consent on file — tick "Consent on file" first.');
                        }
                    },
                ]),

            DateTimePicker::make('published_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quote')->limit(60),
                TextColumn::make('attribution'),
                TextColumn::make('service.title')->label('Service')->placeholder('—'),
                IconColumn::make('consent_on_file')->boolean(),
                BadgeColumn::make('status')->formatStateUsing(fn (PublishStatus $state) => $state->label()),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
