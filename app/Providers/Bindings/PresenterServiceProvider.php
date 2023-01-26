<?php

namespace App\Providers\Bindings;

use App\Presenters\IndexOrderPresenter;
use App\Presenters\Interfaces\IndexOrderPresenterInterface;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IndexOrderPresenterInterface::class, IndexOrderPresenter::class);
    }
}
