<?php

namespace App\Providers;

use App\Policies\SettingsPolicy;
use App\Settings\AnnouncementSettings;
use App\Settings\ComplianceSettings;
use App\Settings\ContactSettings;
use App\Settings\CqcSettings;
use App\Settings\MaintenanceSettings;
use App\Settings\NotificationSettings;
use App\Settings\OrganisationSettings;
use App\Settings\SocialSeoSettings;
use App\Support\Csp\Nonce;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Settings classes aren't Eloquent models, so Laravel's policy
     * auto-discovery (App\Models\X -> App\Policies\XPolicy) can't find a
     * policy for them — they're registered explicitly here instead.
     */
    protected const SETTINGS_CLASSES = [
        OrganisationSettings::class,
        ContactSettings::class,
        CqcSettings::class,
        NotificationSettings::class,
        SocialSeoSettings::class,
        AnnouncementSettings::class,
        ComplianceSettings::class,
        MaintenanceSettings::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Nonce::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('nonce', function () {
            return "<?php echo 'nonce=\"'.e(app(\App\Support\Csp\Nonce::class)->value()).'\"'; ?>";
        });

        foreach (self::SETTINGS_CLASSES as $settingsClass) {
            Gate::policy($settingsClass, SettingsPolicy::class);
        }

        Event::listen(function (Login $event) {
            activity('auth')->causedBy($event->user->getAuthIdentifier())->withProperties(['ip' => request()->ip()])->log('session started');
        });

        Event::listen(function (Logout $event) {
            activity('auth')->causedBy($event->user->getAuthIdentifier())->withProperties(['ip' => request()->ip()])->log('session ended');
        });
    }
}
