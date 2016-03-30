<?php
namespace App\Modules\Initializer\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class InitializerServiceProvider extends ServiceProvider
{
	/**
	 * Register the Initializer module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Initializer\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Initializer module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('initializer', realpath(__DIR__.'/../Resources/Lang'));

		View::addNamespace('initializer', base_path('resources/views/vendor/initializer'));
		View::addNamespace('initializer', realpath(__DIR__.'/../Resources/Views'));
	}
}
