<?php

namespace App\Repositories\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;

interface OrderSearchRepositoryInterface
{
    public function make(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO;
}
