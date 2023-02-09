<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Repositories\Interfaces\OrderDestroyRepositoryInterface;

class OrderDestroyRepository implements OrderDestroyRepositoryInterface
{
    public function make(OrderResponseDTOInterface $responseDTO): void
    {
        $responseDTO->order->delete();
    }
}
