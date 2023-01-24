<?php

namespace App\Providers\Bindings;

use App\Helpers\EnumSerializerHelperHelper;
use App\Helpers\Interfaces\EnumSerializerHelperInterface;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Helpers\RequestFilterHelper;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EnumSerializerHelperInterface::class, EnumSerializerHelperHelper::class);

        $this->app->bind(
            RequestFilterHelperInterface::class,
            function (Application $app, array $params): RequestFilterHelper {
                return new RequestFilterHelper($params['data']);
            }
        );
    }
}
