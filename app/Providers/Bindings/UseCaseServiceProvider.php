<?php

namespace App\Providers\Bindings;

use App\UseCases\AdminPanel\Order\IndexOrderUseCase;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;
use Illuminate\Support\ServiceProvider;

class UseCaseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IndexOrderUseCaseInterface::class, IndexOrderUseCase::class);
    }

    public function boot(): void
    {
        //
    }
}
