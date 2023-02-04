<?php

namespace App\Providers\Bindings;

use App\Http\Requests\OrderIndexRequest;
use App\Http\Requests\Interfaces\OrderIndexRequestInterface;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderIndexRequestInterface::class, OrderIndexRequest::class);
    }
}
