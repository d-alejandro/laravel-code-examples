<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface LoggerServiceInterface
{
    public function make(Model $model): void;
}
