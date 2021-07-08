<?php

namespace App\Repositories\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\UpdateOrderDTO;
use App\Models\Order;

interface OrderUpdaterRepositoryInterface
{
    public function make(UpdateOrderDTO $updateOrderDTO): Order;
}
