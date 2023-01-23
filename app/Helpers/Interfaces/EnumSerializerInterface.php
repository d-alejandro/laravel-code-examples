<?php

namespace App\Helpers\Interfaces;

interface EnumSerializerInterface
{
    public function execute(string $enum): string;
}
