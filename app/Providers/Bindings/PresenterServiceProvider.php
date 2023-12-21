<?php

namespace App\Providers\Bindings;

use App\Http\Controllers\Api\OrderStoreController;
use App\Presenters\Interfaces\OrderPresenterInterface;
use App\Presenters\OrderCreatedPresenter;
use App\Presenters\OrderListPresenter;
use App\Presenters\Interfaces\OrderListPresenterInterface;
use App\Presenters\OrderPresenter;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderListPresenterInterface::class, OrderListPresenter::class);
        $this->app->bind(OrderPresenterInterface::class, OrderPresenter::class);

        $this->app->when(OrderStoreController::class)
            ->needs(OrderPresenterInterface::class)
            ->give(OrderCreatedPresenter::class);
    }
}
