<?php

namespace App\Providers\Bindings;

use App\Helpers\EnumSerializer;
use App\Helpers\Interfaces\EnumSerializerInterface;
use App\Helpers\Interfaces\BooleanFilterInterface;
use App\Helpers\BooleanFilter;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EnumSerializerInterface::class, EnumSerializer::class);
        $this->app->bind(BooleanFilterInterface::class, BooleanFilter::class);
    }

    public function boot(): void
    {
        //
    }
}
