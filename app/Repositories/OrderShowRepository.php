<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderShowResponseDTOInterface;
use App\Repositories\Interfaces\OrderShowRepositoryInterface;

class OrderShowRepository implements OrderShowRepositoryInterface
{
    public function make(int $id): OrderShowResponseDTOInterface
    {
    }
}
