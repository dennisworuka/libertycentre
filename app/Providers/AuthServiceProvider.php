<?php

namespace App\Providers;

use App\Models\MediaAsset;
use App\Models\MenuItem;
use App\Models\CompliancePage;
use App\Models\Download;
use App\Models\Faq;
use App\Models\HomepageSection;
use App\Models\HomepageSlide;
use App\Models\Page;
use App\Models\ServicePage;
use App\Models\SiteSetting;
use App\Models\TeamMember;
use App\Models\User;
use App\Policies\ActivityPolicy;
use App\Policies\CompliancePagePolicy;
use App\Policies\DownloadPolicy;
use App\Policies\FaqPolicy;
use App\Policies\MediaAssetPolicy;
use App\Policies\MenuItemPolicy;
use App\Policies\HomepageSectionPolicy;
use App\Policies\HomepageSlidePolicy;
use App\Policies\PagePolicy;
use App\Policies\ServicePagePolicy;
use App\Policies\SiteSettingPolicy;
use App\Policies\TeamMemberPolicy;
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
        Page::class => PagePolicy::class,
        ServicePage::class => ServicePagePolicy::class,
        TeamMember::class => TeamMemberPolicy::class,
        CompliancePage::class => CompliancePagePolicy::class,
        Faq::class => FaqPolicy::class,
        Download::class => DownloadPolicy::class,
        HomepageSlide::class => HomepageSlidePolicy::class,
        HomepageSection::class => HomepageSectionPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];
}
