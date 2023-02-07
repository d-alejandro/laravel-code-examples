<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderShowResponseDTOInterface;

interface OrderShowRepositoryInterface
{
    public function make(int $id): OrderShowResponseDTOInterface;
}
