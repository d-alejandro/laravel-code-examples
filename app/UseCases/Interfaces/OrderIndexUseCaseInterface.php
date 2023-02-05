<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\DTO\Interfaces\OrderIndexResponseDTOInterface;

interface OrderIndexUseCaseInterface
{
    public function execute(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTOInterface;
}
