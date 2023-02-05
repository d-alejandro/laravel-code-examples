<?php

namespace App\Services;

use App\Services\Interfaces\LoggerServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LoggerService implements LoggerServiceInterface
{
    public function make(Model $model): void
    {
        $className = class_basename($model);
        $classNameLower = strtolower($className);

        Log::info("$className added. \n", [
            "__{$classNameLower}__" => print_r($model->toArray(), true),
        ]);
    }
}
