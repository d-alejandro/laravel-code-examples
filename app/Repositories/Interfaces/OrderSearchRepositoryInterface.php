<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\DTO\Interfaces\OrderIndexResponseDTOInterface;

interface OrderSearchRepositoryInterface
{
    public function make(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTOInterface;
}
