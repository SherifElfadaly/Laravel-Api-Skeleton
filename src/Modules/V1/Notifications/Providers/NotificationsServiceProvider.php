<?php
namespace App\Modules\V1\Notifications\Providers;

use App;
use Config;
use Lang;
use View;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
	/**
	 * Register the Notifications module service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// This service provider is a convenient place to register your modules
		// services in the IoC container. If you wish, you may make additional
		// methods or service providers to keep the code more focused and granular.
		App::register('App\Modules\V1\Notifications\Providers\RouteServiceProvider');

		$this->registerNamespaces();
	}

	/**
	 * Register the Notifications module resource namespaces.
	 *
	 * @return void
	 */
	protected function registerNamespaces()
	{
		Lang::addNamespace('notifications', realpath(__DIR__.'/../Resources/Lang'));
		
		View::addNamespace('notifications', base_path('resources/views/vendor/notifications'));
		View::addNamespace('notifications', realpath(__DIR__.'/../Resources/Views'));
	}
}
