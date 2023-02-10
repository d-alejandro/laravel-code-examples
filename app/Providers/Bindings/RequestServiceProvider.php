<?php

namespace App\Providers\Bindings;

use App\Http\Requests\Interfaces\OrderStoreRequestInterface;
use App\Http\Requests\Interfaces\OrderUpdateRequestInterface;
use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\Interfaces\OrderIndexRequestInterface;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexRequestInterface::class, OrderIndexRequest::class);
        $this->app->bind(OrderStoreRequestInterface::class, OrderStoreRequest::class);
        $this->app->bind(OrderUpdateRequestInterface::class, OrderUpdateRequest::class);
    }
}
