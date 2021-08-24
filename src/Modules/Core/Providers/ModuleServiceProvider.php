<?php

namespace App\Modules\Core\Providers;

use App\Modules\Core\Repositories\SettingRepository;
use App\Modules\Core\Repositories\SettingRepositoryInterface;
use App\Modules\Core\Services\SettingService;
use App\Modules\Core\Services\SettingServiceInterface;
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
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('core', 'Config', 'app'));
        }
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        //Bind Core Facade to the Service Container
        $this->app->bind('Core', function () {
            return new \App\Modules\Core\Core;
        });

        //Bind Errors Facade to the Service Container
        $this->app->bind('Errors', function () {
            return new \App\Modules\Core\Errors\Errors;
        });

        //Bind ApiConsumer Facade to the Service Container
        $this->app->bind('ApiConsumer', function ($app) {
            return new \App\Modules\Core\Utl\ApiConsumer($app, $app['request'], $app['router']);
        });
        
        $this->app->register(RouteServiceProvider::class);

        /**
         * Bind interfaces to implmentations.
         */
        $this->app->bind(SettingServiceInterface::class, SettingService::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
    }
}
