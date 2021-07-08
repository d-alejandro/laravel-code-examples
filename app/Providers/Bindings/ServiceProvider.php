<?php

namespace App\Providers\Bindings;

use App\Services\AdminPanel\Order\Interfaces\OrderColumnsCreatorServiceInterface;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderLoggerServiceInterface;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderServiceInterface;
use App\Services\AdminPanel\Order\OrderColumnsCreatorService;
use App\Services\AdminPanel\Order\StoreOrderLoggerService;
use App\Services\AdminPanel\Order\StoreOrderService;
use App\Services\AdminPanel\Order\StoreOrderServiceDecorator;
use App\UseCases\AdminPanel\Order\StoreOrderUseCase;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // AdminPanel/Order
        $this->app->when(StoreOrderUseCase::class)
            ->needs(StoreOrderServiceInterface::class)
            ->give(StoreOrderServiceDecorator::class);

        $this->app->when(StoreOrderServiceDecorator::class)
            ->needs(StoreOrderServiceInterface::class)
            ->give(StoreOrderService::class);

        $this->app->bind(StoreOrderLoggerServiceInterface::class, StoreOrderLoggerService::class);
        $this->app->bind(OrderColumnsCreatorServiceInterface::class, OrderColumnsCreatorService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
