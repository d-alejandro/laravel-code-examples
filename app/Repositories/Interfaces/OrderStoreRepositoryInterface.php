<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderStoreRepositoryInterface
{
    public function make(OrderStoreRequestDTOInterface $requestDTO): OrderResponseDTOInterface;
}
