<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;

interface OrderUpdateUseCaseInterface
{
    public function execute(OrderUpdateRequestDTOInterface $requestDTO, int $id): OrderResponseDTOInterface;
}
