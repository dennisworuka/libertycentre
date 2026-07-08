<?php

namespace App\Providers;

use App\Support\Csp\Nonce;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
    }
}
