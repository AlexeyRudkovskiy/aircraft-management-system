<?php

namespace App\Providers;

use App\Contracts\AircraftServiceContract;
use App\Contracts\MaintenanceCompanyServiceContract;
use App\Services\AircraftService;
use App\Services\MaintenanceCompanyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AircraftServiceContract::class, AircraftService::class);
        $this->app->bind(MaintenanceCompanyServiceContract::class, MaintenanceCompanyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
