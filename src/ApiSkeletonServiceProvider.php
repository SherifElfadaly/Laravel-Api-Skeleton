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
		$this->publishes([
			__DIR__.'/Modules'                               => app_path('Modules'),
			__DIR__.'/Modules/Core/Resources/Assets'         => base_path('public/doc/assets'),
			__DIR__.'/../lang'                               => base_path('resources/lang'),
			__DIR__.'/../files/Handler.php'                  => app_path('Exceptions/Handler.php'),
			__DIR__.'/../files/AuthServiceProvider.php'      => app_path('Providers/AuthServiceProvider.php'),
			__DIR__.'/../files/BroadcastServiceProvider.php' => app_path('Providers/BroadcastServiceProvider.php'),
			__DIR__.'/../files/Kernel.php'                   => app_path('Console/Kernel.php'),
			__DIR__.'/../files/channels.php'                 => app_path('routes/channels.php'),
		]);

		$this->publishes([
			__DIR__.'/../config/skeleton.php' => config_path('skeleton.php'),
			__DIR__.'/../files/auth.php'      => config_path('auth.php'),
		], 'config');
	}

	/**
	 * Register any package services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->mergeConfigFrom(
			__DIR__.'/../config/skeleton.php', 'skeleton'
		);
	}
}