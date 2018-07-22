<?php

namespace App\Modules\Notifications\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'notification');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'notification');
        
        $factory = app('Illuminate\Database\Eloquent\Factory');
        $factory->load(__DIR__.'/../Database/Factories');
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
