<?php

namespace App\Helpers;

use App\Enums\Interfaces\RequestParamEnumInterface;
use App\Helpers\Exceptions\BooleanFilterException;
use App\Helpers\Interfaces\RequestFilterHelperInterface;

class RequestFilterHelper implements RequestFilterHelperInterface
{
    public function __construct(
        private array $data
    ) {
    }

    public function checkRequestParam(RequestParamEnumInterface $requestParam): mixed
    {
        /* @var $requestParam \UnitEnum */
        return $this->data[$requestParam->value] ?? null;
    }

    /**
     * @throws BooleanFilterException
     */
    public function filterBooleanRequestParam(RequestParamEnumInterface $requestParam): bool|null
    {
        /* @var $requestParam \UnitEnum */
        return isset($this->data[$requestParam->value])
            ? $this->filterBooleanValue($this->data[$requestParam->value])
            : null;
    }

    /**
     * @throws BooleanFilterException
     */
    private function filterBooleanValue(string $value): bool
    {
        return match ($value) {
            'true' => true,
            'false' => false,
            default => throw new BooleanFilterException(
                'The param value must be able to be cast as a boolean.'
            ),
        };
    }
}
