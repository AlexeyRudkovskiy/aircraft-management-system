<?php

namespace App\Providers;

use App\Contracts\AircraftServiceContract;
use App\Contracts\MaintenanceCompanyServiceContract;
use App\Contracts\ServiceRequestServiceContract;
use App\Contracts\UserServiceContract;
use App\Services\AircraftService;
use App\Services\MaintenanceCompanyService;
use App\Services\ServiceRequestService;
use App\Services\UserService;
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
        $this->app->bind(ServiceRequestServiceContract::class, ServiceRequestService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
