<?php

namespace App\Modules\PushNotificationDevices\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'push-notification-devices');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'push-notification-devices');

        $this->loadMigrationsFrom(module_path('push-notification-devices', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('push-notification-devices', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
