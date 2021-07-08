<?php

namespace App\Helpers;

use App\Helpers\Interfaces\StringArrayConverterInterface;
use App\Helpers\Interfaces\StringConverterInterface;
use Illuminate\Support\Arr;

class StringArrayConverter implements StringArrayConverterInterface
{
    public function __construct(private StringConverterInterface $stringConverter)
    {
    }

    public function convertToBooleanByKeys(array $assocArray, array $keys): array
    {
        $filteredArray = Arr::only($assocArray, $keys);

        foreach ($filteredArray as $key => $value) {
            $assocArray[$key] = $this->stringConverter->convertToBoolean($value);
        }

        return $assocArray;
    }
}
