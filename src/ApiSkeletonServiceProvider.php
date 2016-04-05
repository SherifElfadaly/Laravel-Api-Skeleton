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
     $this->publishes([__DIR__.'/Modules' => app_path('Modules')]);

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