<?php

namespace App\Helpers;

use App\Exceptions\SystemException;
use App\Helpers\Interfaces\StringConverterInterface;

class StringConverter implements StringConverterInterface
{
    /**
     * @throws SystemException
     */
    public function convertToBoolean(string $value): bool
    {
        return match ($value) {
            'true' => true,
            'false' => false,
            default => throw new SystemException('The param value must be able to be cast as a boolean.'),
        };
    }
}
