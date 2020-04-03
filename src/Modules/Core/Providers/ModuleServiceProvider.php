<?php

namespace App\Modules\Core\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'core');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'core');

        $this->loadMigrationsFrom(module_path('core', 'Database/Migrations', 'app'));
        $this->loadFactoriesFrom(module_path('core', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        //Bind Core Facade to the Service Container
        $this->app->singleton('Core', function () {
            return new \App\Modules\Core\Core;
        });

        //Bind Errors Facade to the Service Container
        $this->app->singleton('Errors', function () {
            return new \App\Modules\Core\Errors\Errors;
        });

        //Bind CoreConfig Facade to the Service Container
        $this->app->singleton('CoreConfig', function () {
            return new \App\Modules\Core\Utl\CoreConfig;
        });

        //Bind Media Facade to the Service Container
        $this->app->singleton('Media', function () {
            return new \App\Modules\Core\Utl\Media;
        });

        //Bind ApiConsumer Facade to the Service Container
        $this->app->singleton('ApiConsumer', function () {
            $app = app();
            return new \App\Modules\Core\Utl\ApiConsumer($app, $app['request'], $app['router']);
        });
        
        $this->app->register(RouteServiceProvider::class);
    }
}
