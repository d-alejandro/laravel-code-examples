<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderStoreUseCaseInterface
{
    public function execute(OrderStoreRequestDTOInterface $requestDTO): OrderResponseDTOInterface;
}
