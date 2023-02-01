<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\DTO\Interfaces\IndexOrderResponseDTOInterface;

interface IndexOrderUseCaseInterface
{
    public function execute(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTOInterface;
}
