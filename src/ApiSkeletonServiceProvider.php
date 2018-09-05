<?php

namespace ApiSkeleton\ApiSkeleton;

use Illuminate\Support\ServiceProvider;

class ApiSkeletonServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Modules'                               => app_path('Modules'),
            __DIR__.'/../lang'                               => base_path('resources/lang'),
            __DIR__.'/../files/Handler.php'                  => base_path('app/Exceptions/Handler.php'),
            __DIR__.'/../files/auth.php'                     => base_path('config/auth.php'),
            __DIR__.'/../files/AuthServiceProvider.php'      => base_path('app/Providers/AuthServiceProvider.php'),
            __DIR__.'/../files/BroadcastServiceProvider.php' => base_path('app/Providers/BroadcastServiceProvider.php'),
            __DIR__.'/../files/Kernel.php'                   => base_path('app/Console/Kernel.php'),
        ]);

        $this->publishes([
            __DIR__.'/../config/skeleton.php' => config_path('skeleton.php'),
        ], 'config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}