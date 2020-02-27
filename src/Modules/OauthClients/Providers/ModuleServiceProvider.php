<?php

namespace App\Modules\OauthClients\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'oauth-clients');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'oauth-clients');

        $this->loadMigrationsFrom(module_path('oauth-clients', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('oauth-clients', 'Database/Factories', 'app'));
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
