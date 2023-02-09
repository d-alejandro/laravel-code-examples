<?php

namespace App\Providers\Bindings;

use App\Models\Order;
use App\Repositories\AgencyByNameCreatorRepository;
use App\Repositories\Criteria\CriteriaApplier;
use App\Repositories\Criteria\Interfaces\CriteriaApplierInterface;
use App\Repositories\Interfaces\AgencyByNameCreatorRepositoryInterface;
use App\Repositories\Interfaces\OrderDestroyRepositoryInterface;
use App\Repositories\Interfaces\OrderIndexRepositoryInterface;
use App\Repositories\Interfaces\OrderShowRepositoryInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use App\Repositories\OrderDestroyRepository;
use App\Repositories\OrderIndexRepository;
use App\Repositories\OrderShowRepository;
use App\Repositories\OrderStoreRepository;
use App\Repositories\OrderStoreRepositoryDecorator;
use App\UseCases\OrderStoreUseCase;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexRepositoryInterface::class, OrderIndexRepository::class);

        $this->app->when(OrderIndexRepository::class)
            ->needs(CriteriaApplierInterface::class)
            ->give(fn() => new CriteriaApplier(Order::class));

        $this->app->when(OrderStoreUseCase::class)
            ->needs(OrderStoreRepositoryInterface::class)
            ->give(OrderStoreRepositoryDecorator::class);

        $this->app->when(OrderStoreRepositoryDecorator::class)
            ->needs(OrderStoreRepositoryInterface::class)
            ->give(OrderStoreRepository::class);

        $this->app->bind(AgencyByNameCreatorRepositoryInterface::class, AgencyByNameCreatorRepository::class);

        $this->app->bind(OrderShowRepositoryInterface::class, OrderShowRepository::class);

        $this->app->when(OrderShowRepository::class)
            ->needs(CriteriaApplierInterface::class)
            ->give(fn() => new CriteriaApplier(Order::class));

        $this->app->bind(OrderDestroyRepositoryInterface::class, OrderDestroyRepository::class);
    }
}
