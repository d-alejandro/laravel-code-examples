<?php

namespace App\Repositories\Interfaces;

use App\DTO\IndexOrderRequestDTO;
use App\DTO\IndexOrderResponseDTO;

interface OrderSearchRepositoryInterface
{
    public function make(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO;
}
