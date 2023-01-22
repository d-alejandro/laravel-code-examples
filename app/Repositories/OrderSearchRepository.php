<?php

namespace App\Repositories;

use App\DTO\IndexOrderRequestDTO;
use App\DTO\IndexOrderResponseDTO;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;

class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    public function make(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO
    {

    }
}
