<?php

namespace App\Providers;

use App\Contracts\VendingMachineContext;
use App\Models\VendingMachine;
use App\Services\VendingMachineBusinessService;
use App\Services\VendingMachineService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(VendingMachineContext::class, function ($app) {
            $model = VendingMachine::query()->firstOrCreate(['name' => 'Machine 1']);

            return new VendingMachineService($model);
        });

        $this->app->singleton(VendingMachineBusinessService::class, function ($app) {
            return new VendingMachineBusinessService($app->make(VendingMachineContext::class));
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
