<?php

namespace App\Providers\Bindings;

use App\Helpers\EnumHelper;
use App\Helpers\Interfaces\EnumHelperInterface;
use App\Helpers\Interfaces\RequestFilterHelperInterface;
use App\Helpers\RequestFilterHelper;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public const PARAM_REQUEST_PARAMS = 'requestParams';

    public function register(): void
    {
        $this->app->bind(EnumHelperInterface::class, EnumHelper::class);

        $this->app->bind(
            RequestFilterHelperInterface::class,
            fn(Application $app, array $params) => new RequestFilterHelper($params[self::PARAM_REQUEST_PARAMS])
        );
    }
}
