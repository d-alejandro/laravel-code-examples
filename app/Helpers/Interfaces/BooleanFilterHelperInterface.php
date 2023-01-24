<?php

namespace App\Helpers\Interfaces;

interface BooleanFilterHelperInterface
{
    public function execute(string $value): bool;
}
