<?php

namespace App\Providers\Bindings;

use App\Presenter\IndexOrderPresenter;
use App\Presenter\Interfaces\IndexOrderPresenterInterface;
use Illuminate\Support\ServiceProvider;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IndexOrderPresenterInterface::class, IndexOrderPresenter::class);
    }
}
