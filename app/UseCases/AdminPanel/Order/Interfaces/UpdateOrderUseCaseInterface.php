<?php

namespace App\UseCases\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Models\Order;

interface UpdateOrderUseCaseInterface
{
    public function execute(UpdateOrderRequestDTO $updateOrderRequestDTO, int $id): Order;
}
