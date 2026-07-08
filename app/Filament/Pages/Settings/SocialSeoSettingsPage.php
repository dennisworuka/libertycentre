<?php

namespace App\Filament\Pages\Settings;

use App\Settings\SocialSeoSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class SocialSeoSettingsPage extends BaseSettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $title = 'Social & SEO';

    protected static ?string $navigationLabel = 'Social & SEO';

    protected static string $settings = SocialSeoSettings::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('facebook_url')->label('Facebook URL')->url(),
            TextInput::make('twitter_url')->label('X / Twitter URL')->url(),
            TextInput::make('linkedin_url')->label('LinkedIn URL')->url(),
            TextInput::make('instagram_url')->label('Instagram URL')->url(),

            TextInput::make('default_meta_title')
                ->label('Default meta title')
                ->required()
                ->maxLength(255),

            Textarea::make('default_meta_description')
                ->label('Default meta description')
                ->required()
                ->maxLength(320),

            FileUpload::make('default_share_image_media_uuid')
                ->label('Default share image')
                ->image()
                ->directory('social-seo'),
        ];
    }
}
