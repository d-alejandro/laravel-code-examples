<?php

namespace App\Providers\Bindings;

use App\Models\Order;
use App\Repositories\Criteria\CriteriaApplier;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use App\Repositories\OrderSearchRepository;
use App\Repositories\OrderStoreRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderSearchRepositoryInterface::class, OrderSearchRepository::class);

        $this->app->when(OrderSearchRepository::class)
            ->needs(CriteriaApplierInterface::class)
            ->give(fn() => new CriteriaApplier(Order::class));

        $this->app->bind(OrderStoreRepositoryInterface::class, OrderStoreRepository::class);
    }
}
