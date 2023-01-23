<?php

namespace App\Helpers\Interfaces;

interface BooleanFilterInterface
{
    public function execute(string $value): bool;
}
