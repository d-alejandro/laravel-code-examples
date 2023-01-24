<?php

namespace App\Providers\Bindings;

use App\Helpers\EnumSerializerHelperHelper;
use App\Helpers\Interfaces\EnumSerializerHelperInterface;
use App\Helpers\Interfaces\BooleanFilterHelperInterface;
use App\Helpers\BooleanFilterHelperHelper;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EnumSerializerHelperInterface::class, EnumSerializerHelperHelper::class);
        $this->app->bind(BooleanFilterHelperInterface::class, BooleanFilterHelperHelper::class);
    }

    public function boot(): void
    {
        //
    }
}
