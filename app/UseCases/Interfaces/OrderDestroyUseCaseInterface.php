<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderDestroyUseCaseInterface
{
    public function execute(int $id): OrderResponseDTOInterface;
}
