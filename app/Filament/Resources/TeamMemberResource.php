<?php

namespace App\Filament\Resources;

use App\Domain\Content\Enums\PublishStatus;
use App\Domain\Content\Models\TeamMember;
use App\Filament\Resources\TeamMemberResource\Pages;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(2)
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('role')->required()->maxLength(255),
                    TextInput::make('order')->numeric()->default(0),

                    Select::make('status')
                        ->options(collect(PublishStatus::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()]))
                        ->required()
                        ->live(),
                ]),

            Textarea::make('bio')->maxLength(1000)->columnSpanFull(),

            Section::make('Photo')
                ->columns(2)
                ->schema([
                    SpatieMediaLibraryFileUpload::make('photo')
                        ->collection(TeamMember::PHOTO_COLLECTION)
                        ->image()
                        ->columnSpanFull(),

                    TextInput::make('photo_alt')
                        ->label('Alt text')
                        ->helperText('Required before this profile can be published.')
                        ->required(fn (Get $get): bool => $get('status') === PublishStatus::Published->value)
                        ->afterStateHydrated(function (TextInput $component, ?TeamMember $record) {
                            $component->state($record?->getFirstMedia(TeamMember::PHOTO_COLLECTION)?->getCustomProperty('alt'));
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')->collection(TeamMember::PHOTO_COLLECTION)->circular(),
                TextColumn::make('order')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('role'),
                BadgeColumn::make('status')->formatStateUsing(fn (PublishStatus $state) => $state->label()),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
