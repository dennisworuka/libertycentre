<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Support\Permissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Administration';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? $state : null)
                ->dehydrated(fn (?string $state): bool => filled($state))
                ->rule(Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised())
                ->required(fn (string $operation): bool => $operation === 'create'),
            Forms\Components\Select::make('roles')
                ->multiple()
                ->relationship('roles', 'name')
                ->options(array_combine(Permissions::ROLES, Permissions::ROLES))
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('google2fa_secret')
                ->label('TOTP secret')
                ->helperText('Generated during MFA enrolment. Clearing this blocks admin access until re-enrolled.')
                ->maxLength(255),
            Forms\Components\DateTimePicker::make('mfa_confirmed_at')
                ->label('MFA confirmed at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name')->badge(),
                Tables\Columns\IconColumn::make('mfa_confirmed_at')->label('MFA')->boolean(),
                Tables\Columns\TextColumn::make('last_login_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
