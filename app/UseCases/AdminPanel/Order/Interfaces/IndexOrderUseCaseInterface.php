<?php

namespace App\UseCases\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;

interface IndexOrderUseCaseInterface
{
    public function execute(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO;
}
