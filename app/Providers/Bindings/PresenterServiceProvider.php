<?php

namespace App\Providers\Bindings;

use App\Presenters\Interfaces\OrderStorePresenterInterface;
use App\Presenters\OrderIndexPresenter;
use App\Presenters\Interfaces\OrderIndexPresenterInterface;
use App\Presenters\OrderStorePresenter;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexPresenterInterface::class, OrderIndexPresenter::class);
        $this->app->bind(OrderStorePresenterInterface::class, OrderStorePresenter::class);
    }
}
