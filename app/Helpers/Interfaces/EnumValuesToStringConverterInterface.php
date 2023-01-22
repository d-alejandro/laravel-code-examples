<?php

namespace App\Helpers\Interfaces;

interface EnumValuesToStringConverterInterface
{
    public function execute(string $enum): string;
}
