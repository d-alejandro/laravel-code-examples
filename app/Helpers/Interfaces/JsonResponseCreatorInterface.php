<?php

namespace App\Helpers\Interfaces;

use Illuminate\Http\JsonResponse;

interface JsonResponseCreatorInterface
{
    public function createFromResource(string $class, mixed $resource): JsonResponse;

    public function createFromResourceCollection(string $class, mixed $resource): JsonResponse;
}
