<?php

namespace App\Providers\Bindings;

use App\UseCases\OrderIndexUseCase;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexUseCaseInterface::class, OrderIndexUseCase::class);
    }
}
