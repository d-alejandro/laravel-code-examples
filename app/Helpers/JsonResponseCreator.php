<?php

namespace App\Helpers;

use App\Helpers\Interfaces\JsonResponseCreatorInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResponseCreator implements JsonResponseCreatorInterface
{
    public function createFromResource(string $class, mixed $resource): JsonResponse
    {
        return $this->createObject($class, $resource)->response();
    }

    public function createFromResourceCollection(string $class, mixed $resource): JsonResponse
    {
        /**
         * @var JsonResource $class
         */
        return $class::collection($resource)->response();
    }

    private function createObject(string $class, mixed $resource): JsonResource
    {
        return new $class($resource);
    }
}
