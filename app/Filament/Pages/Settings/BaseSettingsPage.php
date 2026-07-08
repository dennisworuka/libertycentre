<?php

namespace App\Filament\Pages\Settings;

use Filament\Pages\SettingsPage;
use Illuminate\Support\Facades\Gate;

abstract class BaseSettingsPage extends SettingsPage
{
    protected static ?string $navigationGroup = 'Settings';

    public static function canAccess(): bool
    {
        return Gate::allows('update', static::getSettings());
    }
}
