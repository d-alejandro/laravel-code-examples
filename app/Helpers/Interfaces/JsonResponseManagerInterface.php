<?php

namespace App\Helpers\Interfaces;

use Illuminate\Http\JsonResponse;

interface JsonResponseManagerInterface
{
    public function setHeader(JsonResponse $response, string $key, array|string $values): void;

    public function setStatusCode(JsonResponse $response, int $code): void;
}
