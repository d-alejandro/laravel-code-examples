<?php

namespace App\Providers\Bindings;

use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use App\Helpers\Interfaces\JsonResponseManagerInterface;
use App\Helpers\EventDispatcher;
use App\Helpers\Interfaces\SettersFillerInterface;
use App\Helpers\JsonResponseCreator;
use App\Helpers\JsonResponseManager;
use App\Helpers\SettersFiller;
use App\Helpers\StringArrayConverter;
use App\Helpers\Interfaces\StringArrayConverterInterface;
use App\Helpers\Interfaces\StringConverterInterface;
use App\Helpers\StringConverter;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StringConverterInterface::class, StringConverter::class);
        $this->app->bind(StringArrayConverterInterface::class, StringArrayConverter::class);
        $this->app->bind(JsonResponseCreatorInterface::class, JsonResponseCreator::class);
        $this->app->bind(JsonResponseManagerInterface::class, JsonResponseManager::class);
        $this->app->bind(EventDispatcherInterface::class, EventDispatcher::class);
        $this->app->bind(SettersFillerInterface::class, SettersFiller::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
