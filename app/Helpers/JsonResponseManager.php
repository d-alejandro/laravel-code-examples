<?php

namespace App\Helpers;

use App\Helpers\Interfaces\JsonResponseManagerInterface;
use Illuminate\Http\JsonResponse;

class JsonResponseManager implements JsonResponseManagerInterface
{
    public function setHeader(JsonResponse $response, string $key, array|string $values): void
    {
        $response->header($key, $values);
    }

    public function setStatusCode(JsonResponse $response, int $code): void
    {
        $response->setStatusCode($code);
    }
}
