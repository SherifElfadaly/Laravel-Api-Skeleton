<?php

namespace App\Modules\DummyModule\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'DummyModuleSlug');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'DummyModuleSlug');

        $this->loadMigrationsFrom(module_path('DummyModuleSlug', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('DummyModuleSlug', 'Config', 'app'));
        }
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
