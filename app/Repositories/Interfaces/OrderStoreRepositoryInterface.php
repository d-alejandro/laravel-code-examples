<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderStoreResponseDTOInterface;

interface OrderStoreRepositoryInterface
{
    public function make(OrderStoreRequestDTOInterface $requestDTO): OrderStoreResponseDTOInterface;
}
