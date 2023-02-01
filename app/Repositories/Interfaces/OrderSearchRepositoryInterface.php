<?php

namespace App\Repositories\Interfaces;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\DTO\Interfaces\IndexOrderResponseDTOInterface;

interface OrderSearchRepositoryInterface
{
    public function make(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTOInterface;
}
