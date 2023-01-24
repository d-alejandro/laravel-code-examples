<?php

namespace App\Providers\Bindings;

use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\Repositories\OrderSearchRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderSearchRepositoryInterface::class, OrderSearchRepository::class);
    }
}
