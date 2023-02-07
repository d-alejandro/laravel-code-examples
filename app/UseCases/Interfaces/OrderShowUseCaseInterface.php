<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderShowUseCaseInterface
{
    public function execute(int $id): OrderResponseDTOInterface;
}
