<?php

namespace App\Modules\DummyModule\Providers;

use App\Modules\DummyModule\Repositories\DummyRepository;
use App\Modules\DummyModule\Repositories\DummyRepositoryInterface;
use App\Modules\DummyModule\Services\DummyService;
use App\Modules\DummyModule\Services\DummyServiceInterface;
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

        /**
         * Bind interfaces to implmentations.
         */
        $this->app->bind(DummyServiceInterface::class, DummyService::class);
        $this->app->bind(DummyRepositoryInterface::class, DummyRepository::class);
    }
}
