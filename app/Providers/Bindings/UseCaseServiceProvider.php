<?php

namespace App\Providers\Bindings;

use App\UseCases\Interfaces\OrderStoreUseCaseInterface;
use App\UseCases\OrderIndexUseCase;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use App\UseCases\OrderStoreUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexUseCaseInterface::class, OrderIndexUseCase::class);
        $this->app->bind(OrderStoreUseCaseInterface::class, OrderStoreUseCase::class);
    }
}
