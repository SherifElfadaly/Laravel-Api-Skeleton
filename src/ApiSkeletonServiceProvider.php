<?php

namespace api_skeleton\api_skeleton;

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
        __DIR__.'/Exceptions'    => app_path('Exceptions'),
        __DIR__.'/Modules'       => app_path('Modules'),
        __DIR__.'/notifications' => app_path('notifications'),
        __DIR__.'/Kernel.php'    => app_path('Http/Kernel.php'),

        ]);

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