<?php

namespace App\Repositories\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\StoreOrderDTO;
use App\Models\Order;

interface OrderCreatorRepositoryInterface
{
    public function make(StoreOrderDTO $storeOrderDTO): Order;
}
