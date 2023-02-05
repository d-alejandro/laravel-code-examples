<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderStoreResponseDTOInterface;

interface OrderStoreUseCaseInterface
{
    public function execute(OrderStoreRequestDTOInterface $requestDTO): OrderStoreResponseDTOInterface;
}
