<?php

namespace App\Modules\Reporting\Providers;

use App\Modules\Reporting\Repositories\ReportRepository;
use App\Modules\Reporting\Repositories\ReportRepositoryInterface;
use App\Modules\Reporting\Services\ReportService;
use App\Modules\Reporting\Services\ReportServiceInterface;
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
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'reporting');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'reporting');

        $this->loadMigrationsFrom(module_path('reporting', 'Database/Migrations', 'app'));
        if (!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('reporting', 'Config', 'app'));
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
        $this->app->bind(ReportServiceInterface::class, ReportService::class);
        $this->app->bind(ReportRepositoryInterface::class, ReportRepository::class);
    }
}
