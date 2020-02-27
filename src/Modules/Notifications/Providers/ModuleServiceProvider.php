<?php

namespace App\Modules\Notifications\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'notifications');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'notifications');

        $this->loadMigrationsFrom(module_path('notifications', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('notifications', 'Database/Factories', 'app'));
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
