<?php

namespace App\Helpers;

use App\Enums\Interfaces\RequestParamEnumInterface;
use App\Helpers\Exceptions\BooleanFilterHelperException;
use App\Helpers\Interfaces\RequestFilterHelperInterface;

class RequestFilterHelper implements RequestFilterHelperInterface
{
    public function __construct(
        private array $requestParams
    ) {
    }

    public function checkRequestParam(RequestParamEnumInterface $requestParam): mixed
    {
        return $this->requestParams[$requestParam->value] ?? null;
    }

    /**
     * @throws BooleanFilterHelperException
     */
    public function filterBooleanRequestParam(RequestParamEnumInterface $requestParam): bool|null
    {
        return isset($this->requestParams[$requestParam->value])
            ? $this->filterBooleanValue($this->requestParams[$requestParam->value])
            : null;
    }

    /**
     * @throws BooleanFilterHelperException
     */
    private function filterBooleanValue(string $value): bool
    {
        return match ($value) {
            'true' => true,
            'false' => false,
            default => throw new BooleanFilterHelperException(
                'The param value must be able to be cast as a boolean.'
            ),
        };
    }
}
