<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderStoreResponseDTOInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;

class OrderStoreRepository implements OrderStoreRepositoryInterface
{
    public function make(OrderStoreRequestDTOInterface $requestDTO): OrderStoreResponseDTOInterface
    {
    }
}
