<?php

namespace App\Repositories;

use App\DTO\IndexOrderResponseDTO;
use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;

class OrderSearchRepository implements OrderSearchRepositoryInterface
{
    public function make(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTO
    {

    }
}
