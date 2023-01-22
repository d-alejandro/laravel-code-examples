<?php

namespace App\Providers\Bindings;

use App\Helpers\EnumValuesToStringConverter;
use App\Helpers\Interfaces\EnumValuesToStringConverterInterface;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EnumValuesToStringConverterInterface::class, EnumValuesToStringConverter::class);
    }

    public function boot(): void
    {
        //
    }
}
