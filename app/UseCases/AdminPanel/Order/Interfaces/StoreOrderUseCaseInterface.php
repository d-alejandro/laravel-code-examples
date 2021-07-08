<?php

namespace App\UseCases\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Models\Order;

interface StoreOrderUseCaseInterface
{
    public function execute(StoreOrderRequestDTO $storeOrderRequestDTO): Order;
}
