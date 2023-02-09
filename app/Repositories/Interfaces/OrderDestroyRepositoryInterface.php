<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderDestroyRepositoryInterface
{
    public function make(OrderResponseDTOInterface $responseDTO): void;
}
