<?php

namespace App\Providers\Bindings;

use App\Models\Agency;
use App\Models\Order;
use App\Repositories\AdminPanel\Agency\Interfaces\AgencyCreatorByNameRepositoryInterface;
use App\Repositories\AdminPanel\Agency\AgencyCreatorByNameRepository;
use App\Repositories\AdminPanel\Order\Interfaces\OrderDestroyerRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrdersLoaderRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderCreatorRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderUpdaterRepositoryInterface;
use App\Repositories\AdminPanel\Order\OrderDestroyerRepository;
use App\Repositories\AdminPanel\Order\OrdersLoaderRepository;
use App\Repositories\AdminPanel\Order\OrderLoaderRepository;
use App\Repositories\AdminPanel\Order\OrderCreatorRepository;
use App\Repositories\AdminPanel\Order\OrderUpdaterRepository;
use App\Repositories\Query\ExpressionBuilder;
use App\Repositories\Query\ExpressionBuilderInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // AdminPanel/Order
        $this->app->bind(OrdersLoaderRepositoryInterface::class, OrdersLoaderRepository::class);
        $this->app->bind(OrderLoaderRepositoryInterface::class, OrderLoaderRepository::class);
        $this->app->bind(OrderCreatorRepositoryInterface::class, OrderCreatorRepository::class);
        $this->app->bind(OrderUpdaterRepositoryInterface::class, OrderUpdaterRepository::class);
        $this->app->bind(OrderDestroyerRepositoryInterface::class, OrderDestroyerRepository::class);

        $this->app->when([
            OrdersLoaderRepository::class,
            OrderLoaderRepository::class,
        ])
            ->needs(ExpressionBuilderInterface::class)
            ->give(fn() => new ExpressionBuilder(Order::class));

        // AdminPanel/Agency
        $this->app->bind(AgencyCreatorByNameRepositoryInterface::class, AgencyCreatorByNameRepository::class);

        $this->app->when(AgencyCreatorByNameRepository::class)
            ->needs(ExpressionBuilderInterface::class)
            ->give(fn() => new ExpressionBuilder(Agency::class));
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
