<?php

namespace App\Providers\Bindings;

use App\Presenter\AdminPanel\Order\Interfaces\IndexOrderPresenterInterface;
use App\Presenter\AdminPanel\Order\Interfaces\ShowOrderPresenterInterface;
use App\Presenter\AdminPanel\Order\Interfaces\OrderPresenterInterface;
use App\Presenter\AdminPanel\Order\IndexOrderPresenter;
use App\Presenter\AdminPanel\Order\ShowOrderPresenter;
use App\Presenter\AdminPanel\Order\OrderPresenter;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // AdminPanel/Order
        $this->app->bind(IndexOrderPresenterInterface::class, IndexOrderPresenter::class);
        $this->app->bind(ShowOrderPresenterInterface::class, ShowOrderPresenter::class);
        $this->app->bind(OrderPresenterInterface::class, OrderPresenter::class);
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
