<?php

namespace App\Services\AdminPanel\Order\Interfaces;

interface OrderColumnsCreatorServiceInterface
{
    public function make(array $properties): array;
}
