<?php

namespace App\Modules\V1\Core\Providers;

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
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        //Bind Core Facade to the IoC Container
        \App::bind('Core', function()
        {
            return new \App\Modules\V1\Core\Core;
        });

        //Bind ErrorHandler Facade to the IoC Container
        \App::bind('ErrorHandler', function()
        {
            return new \App\Modules\V1\Core\Utl\ErrorHandler;
        });

        //Bind CoreConfig Facade to the IoC Container
        \App::bind('CoreConfig', function()
        {
            return new \App\Modules\V1\Core\Utl\CoreConfig;
        });

        //Bind Logging Facade to the IoC Container
        \App::bind('Logging', function()
        {
            return new \App\Modules\V1\Core\Utl\Logging;
        });
        
        $this->app->register(RouteServiceProvider::class);
    }
}
