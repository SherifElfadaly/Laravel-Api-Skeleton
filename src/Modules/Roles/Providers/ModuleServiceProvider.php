<?php

namespace App\Modules\Roles\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'roles');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'roles');

        $this->loadMigrationsFrom(module_path('roles', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('roles', 'Database/Factories', 'app'));
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
