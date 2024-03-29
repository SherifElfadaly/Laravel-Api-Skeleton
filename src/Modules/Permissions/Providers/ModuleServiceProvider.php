<?php

namespace App\Modules\Permissions\Providers;

use App\Modules\Permissions\Repositories\PermissionRepository;
use App\Modules\Permissions\Repositories\PermissionRepositoryInterface;
use App\Modules\Permissions\Services\PermissionService;
use App\Modules\Permissions\Services\PermissionServiceInterface;
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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'permissions');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'permissions');

        $this->loadMigrationsFrom(module_path('permissions', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('permissions', 'Config', 'app'));
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
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }
}
