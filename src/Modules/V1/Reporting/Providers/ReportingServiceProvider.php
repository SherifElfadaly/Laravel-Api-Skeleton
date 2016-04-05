<?php
namespace App\Modules\V1\Reporting\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class ReportingServiceProvider extends ServiceProvider
{
	/**
	 * Register the Reporting module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\V1\Reporting\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Reporting module resource namespaces.
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
