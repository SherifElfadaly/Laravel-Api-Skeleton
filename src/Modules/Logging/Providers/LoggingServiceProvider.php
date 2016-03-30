<?php
namespace App\Modules\Logging\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
	/**
	 * Register the Logging module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Logging\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Logging module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('logging', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('logging', base_path('resources/views/vendor/logging'));
		View::addNamespace('logging', realpath(__DIR__.'/../Resources/Views'));
	}
}
