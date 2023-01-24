<?php

namespace App\Helpers\Interfaces;

interface EnumSerializerHelperInterface
{
    public function execute(string $enum): string;
}
