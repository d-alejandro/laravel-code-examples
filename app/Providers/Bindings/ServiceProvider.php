<?php

namespace App\Providers\Bindings;

use App\Services\Interfaces\LoggerServiceInterface;
use App\Services\LoggerService;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoggerServiceInterface::class, LoggerService::class);
    }
}
