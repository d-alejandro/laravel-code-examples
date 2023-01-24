<?php

namespace App\Helpers;

use App\Helpers\Exceptions\BooleanFilterException;
use App\Helpers\Interfaces\BooleanFilterHelperInterface;

class BooleanFilterHelperHelper implements BooleanFilterHelperInterface
{
    /**
     * @throws BooleanFilterException
     */
    public function execute(string $value): bool
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
