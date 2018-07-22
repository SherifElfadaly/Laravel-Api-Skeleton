<?php

namespace App\Modules\Core\Providers;

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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'core');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'core');

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
        //Bind Core Facade to the IoC Container
        \App::bind('Core', function()
        {
            return new \App\Modules\Core\Core;
        });

        //Bind ErrorHandler Facade to the IoC Container
        \App::bind('ErrorHandler', function()
        {
            return new \App\Modules\Core\Utl\ErrorHandler;
        });

        //Bind CoreConfig Facade to the IoC Container
        \App::bind('CoreConfig', function()
        {
            return new \App\Modules\Core\Utl\CoreConfig;
        });

        //Bind Mpgs Facade to the IoC Container
        \App::bind('Media', function()
        {
            return new \App\Modules\Core\Utl\Media;
        });

        \Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow   = ['png', 'jpg', 'svg'];
            $format  = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        });
        
        $this->app->register(RouteServiceProvider::class);
    }
}
