<?php

namespace App\Modules\Users\Providers;

use App\Modules\Users\Repositories\UserRepository;
use App\Modules\Users\Repositories\UserRepositoryInterface;
use App\Modules\Users\Services\UserService;
use App\Modules\Users\Services\UserServiceInterface;
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
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('users', 'Config', 'app'));
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
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
