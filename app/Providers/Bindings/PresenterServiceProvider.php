<?php

namespace App\Providers\Bindings;

use App\Presenters\OrderIndexPresenter;
use App\Presenters\Interfaces\OrderIndexPresenterInterface;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexPresenterInterface::class, OrderIndexPresenter::class);
    }
}
