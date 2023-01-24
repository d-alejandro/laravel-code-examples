<?php

namespace App\Providers\Bindings;

use App\Http\Requests\IndexOrderRequest;
use App\Http\Requests\Interfaces\IndexOrderRequestInterface;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IndexOrderRequestInterface::class, IndexOrderRequest::class);
    }
}
