<?php

namespace App\Helpers\Interfaces;

interface StringArrayConverterInterface
{
    public function convertToBooleanByKeys(array $assocArray, array $keys): array;
}
