<?php

namespace App\Modules\Notifications\Providers;

use App\Modules\Notifications\Repositories\NotificationRepository;
use App\Modules\Notifications\Repositories\NotificationRepositoryInterface;
use App\Modules\Notifications\Services\NotificationService;
use App\Modules\Notifications\Services\NotificationServiceInterface;
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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'notifications');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'notifications');

        $this->loadMigrationsFrom(module_path('notifications', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('notifications', 'Config', 'app'));
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
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
    }
}
