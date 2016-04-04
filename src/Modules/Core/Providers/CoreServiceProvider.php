<?php
namespace App\Modules\Core\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
	/**
	 * Register the Core module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Core\Providers\RouteServiceProvider');
		
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

		//Bind Logging Facade to the IoC Container
		\App::bind('Logging', function()
		{
			return new \App\Modules\Core\Utl\Logging;
		});
		
		$this->registerNamespaces();
	}

	/**
	 * Register the Core module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('core', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('core', realpath(__DIR__.'/../Resources/Views'));
	}
}
