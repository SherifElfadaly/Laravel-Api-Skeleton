<?php

namespace App\Modules\PushNotificationDevices\Providers;

use App\Modules\PushNotificationDevices\Repositories\PushNotificationDeviceRepository;
use App\Modules\PushNotificationDevices\Repositories\PushNotificationDeviceRepositoryInterface;
use App\Modules\PushNotificationDevices\Services\PushNotificationDeviceService;
use App\Modules\PushNotificationDevices\Services\PushNotificationDeviceServiceInterface;
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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'push-notification-devices');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'push-notification-devices');

        $this->loadMigrationsFrom(module_path('push-notification-devices', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('push-notification-devices', 'Config', 'app'));
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
        $this->app->bind(PushNotificationDeviceServiceInterface::class, PushNotificationDeviceService::class);
        $this->app->bind(PushNotificationDeviceRepositoryInterface::class, PushNotificationDeviceRepository::class);
    }
}
