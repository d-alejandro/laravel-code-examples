<?php

namespace App\Providers\Bindings;

use App\UseCases\Interfaces\OrderDestroyUseCaseInterface;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use App\UseCases\Interfaces\OrderStoreUseCaseInterface;
use App\UseCases\Interfaces\OrderUpdateUseCaseInterface;
use App\UseCases\OrderDestroyUseCase;
use App\UseCases\OrderIndexUseCase;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use App\UseCases\OrderShowUseCase;
use App\UseCases\OrderStoreUseCase;
use App\UseCases\OrderUpdateUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexUseCaseInterface::class, OrderIndexUseCase::class);
        $this->app->bind(OrderStoreUseCaseInterface::class, OrderStoreUseCase::class);
        $this->app->bind(OrderShowUseCaseInterface::class, OrderShowUseCase::class);
        $this->app->bind(OrderDestroyUseCaseInterface::class, OrderDestroyUseCase::class);
        $this->app->bind(OrderUpdateUseCaseInterface::class, OrderUpdateUseCase::class);
    }
}
