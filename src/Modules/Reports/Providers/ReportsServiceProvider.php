<?php
namespace App\Modules\Reports\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
	/**
	 * Register the Reports module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Reports\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Reports module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('reports', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('reports', base_path('resources/views/vendor/reports'));
		View::addNamespace('reports', realpath(__DIR__.'/../Resources/Views'));
	}
}
