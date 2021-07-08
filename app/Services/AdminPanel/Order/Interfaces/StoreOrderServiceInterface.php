<?php

namespace App\Services\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Models\Order;

interface StoreOrderServiceInterface
{
    public function make(StoreOrderRequestDTO $storeOrderRequestDTO): Order;
}
