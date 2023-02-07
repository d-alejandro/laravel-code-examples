<?php

namespace App\UseCases\Interfaces;

use App\DTO\Interfaces\OrderShowResponseDTOInterface;

interface OrderShowUseCaseInterface
{
    public function execute(int $id): OrderShowResponseDTOInterface;
}
