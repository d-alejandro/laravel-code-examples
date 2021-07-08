<?php

namespace App\Helpers\Interfaces;

interface StringConverterInterface
{
    public function convertToBoolean(string $value): bool;
}
