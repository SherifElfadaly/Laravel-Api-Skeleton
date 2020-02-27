<?php

namespace App\Modules\Permissions\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'permissions');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'permissions');

        $this->loadMigrationsFrom(module_path('permissions', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('permissions', 'Database/Factories', 'app'));
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
