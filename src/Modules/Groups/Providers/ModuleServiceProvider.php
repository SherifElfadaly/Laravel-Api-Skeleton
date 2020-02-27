<?php

namespace App\Modules\Groups\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'groups');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'groups');

        $this->loadMigrationsFrom(module_path('groups', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('groups', 'Database/Factories', 'app'));
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
