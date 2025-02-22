<?php

namespace App\Providers;

use App\Interfaces\IVendingMachine;
use App\Models\Machine;
use App\Services\VendingOperationService;
use App\Services\VendingService;
use App\States\IdleState;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IVendingMachine::class, function ($app) {
            return new VendingService();
        });

        $this->app->singleton(VendingOperationService::class, function ($app) {
            return new VendingOperationService($app->make(IVendingMachine::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
