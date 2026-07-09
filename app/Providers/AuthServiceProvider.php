<?php

namespace App\Providers;

use App\Models\MediaAsset;
use App\Models\MenuItem;
use App\Models\SiteSetting;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\MediaAssetPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\SiteSettingPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        SiteSetting::class => SiteSettingPolicy::class,
        MediaAsset::class => MediaAssetPolicy::class,
        MenuItem::class => MenuItemPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];
}
