<?php

namespace App\Modules\OauthClients\Providers;

use App\Modules\OauthClients\Repositories\OauthClientRepository;
use App\Modules\OauthClients\Repositories\OauthClientRepositoryInterface;
use App\Modules\OauthClients\Services\OauthClientService;
use App\Modules\OauthClients\Services\OauthClientServiceInterface;
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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'oauth-clients');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'oauth-clients');

        $this->loadMigrationsFrom(module_path('oauth-clients', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('oauth-clients', 'Config', 'app'));
        }
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        /**
         * Bind interfaces to implmentations.
         */
        $this->app->bind(OauthClientServiceInterface::class, OauthClientService::class);
        $this->app->bind(OauthClientRepositoryInterface::class, OauthClientRepository::class);
    }
}
