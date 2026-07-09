<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompliancePageResource\Pages;
use App\Models\CompliancePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompliancePageResource extends Resource
{
    protected static ?string $model = CompliancePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('summary')->rows(3)->columnSpanFull(),
            Forms\Components\DatePicker::make('last_reviewed_at')->required(),
            Forms\Components\Toggle::make('is_published')->default(true),
            Forms\Components\Repeater::make('content')
                ->schema([
                    Forms\Components\TextInput::make('heading')->required(),
                    Forms\Components\Textarea::make('body')->required()->rows(5),
                ])
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('last_reviewed_at')->date()->sortable(),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompliancePages::route('/'),
            'create' => Pages\CreateCompliancePage::route('/create'),
            'edit' => Pages\EditCompliancePage::route('/{record}/edit'),
        ];
    }
}
