<?php
namespace App\Modules\Acl\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
	/**
	 * Register the Acl module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\Acl\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Acl module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('acl', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('acl', base_path('resources/views/vendor/acl'));
		View::addNamespace('acl', realpath(__DIR__.'/../Resources/Views'));
	}
}
