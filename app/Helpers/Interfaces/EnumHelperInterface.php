<?php

namespace App\Helpers\Interfaces;

interface EnumHelperInterface
{
    public function getValues(string $enum): array;

    public function serialize(string $enum): string;
}
