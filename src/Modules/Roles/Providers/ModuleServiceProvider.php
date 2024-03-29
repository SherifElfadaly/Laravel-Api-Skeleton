<?php

namespace App\Modules\Roles\Providers;

use App\Modules\Roles\Repositories\RoleRepository;
use App\Modules\Roles\Repositories\RoleRepositoryInterface;
use App\Modules\Roles\Services\RoleService;
use App\Modules\Roles\Services\RoleServiceInterface;
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
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('roles', 'Config', 'app'));
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
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}
