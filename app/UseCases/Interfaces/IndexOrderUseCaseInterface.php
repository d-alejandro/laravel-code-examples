<?php

namespace App\UseCases\Interfaces;

use App\DTO\IndexOrderRequestDTO;
use App\DTO\IndexOrderResponseDTO;

interface IndexOrderUseCaseInterface
{
    public function execute(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO;
}
