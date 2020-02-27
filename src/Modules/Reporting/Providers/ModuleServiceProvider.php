<?php

namespace App\Modules\Reporting\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'reporting');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'reporting');

        $this->loadMigrationsFrom(module_path('reporting', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('reporting', 'Database/Factories', 'app'));
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
