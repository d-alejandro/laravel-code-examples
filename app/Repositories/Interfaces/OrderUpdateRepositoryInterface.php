<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;

interface OrderUpdateRepositoryInterface
{
    public function make(OrderResponseDTOInterface $responseDTO, OrderUpdateRequestDTOInterface $requestDTO): void;
}
