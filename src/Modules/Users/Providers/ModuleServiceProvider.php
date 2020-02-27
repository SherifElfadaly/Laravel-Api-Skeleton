<?php

namespace App\Modules\Users\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'users');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'users');

        $this->loadMigrationsFrom(module_path('users', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('users', 'Database/Factories', 'app'));
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
