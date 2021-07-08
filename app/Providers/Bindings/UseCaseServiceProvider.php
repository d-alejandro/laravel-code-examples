<?php

namespace App\Providers\Bindings;

use App\UseCases\AdminPanel\Order\DestroyOrderUseCase;
use App\UseCases\AdminPanel\Order\Interfaces\DestroyOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Interfaces\ShowOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Interfaces\StoreOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\IndexOrderUseCase;
use App\UseCases\AdminPanel\Order\Interfaces\UpdateOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\ShowOrderUseCase;
use App\UseCases\AdminPanel\Order\StoreOrderUseCase;
use App\UseCases\AdminPanel\Order\UpdateOrderUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // AdminPanel/Order
        $this->app->bind(IndexOrderUseCaseInterface::class, IndexOrderUseCase::class);
        $this->app->bind(ShowOrderUseCaseInterface::class, ShowOrderUseCase::class);
        $this->app->bind(StoreOrderUseCaseInterface::class, StoreOrderUseCase::class);
        $this->app->bind(UpdateOrderUseCaseInterface::class, UpdateOrderUseCase::class);
        $this->app->bind(DestroyOrderUseCaseInterface::class, DestroyOrderUseCase::class);
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
