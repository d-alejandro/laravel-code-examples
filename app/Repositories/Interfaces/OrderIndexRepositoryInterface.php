<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\DTO\Interfaces\OrderIndexResponseDTOInterface;

interface OrderIndexRepositoryInterface
{
    public function make(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTOInterface;
}
