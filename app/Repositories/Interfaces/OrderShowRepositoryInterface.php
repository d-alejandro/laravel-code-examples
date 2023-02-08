<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderShowRepositoryInterface
{
    public function make(int $id): OrderResponseDTOInterface;
}
