<?php

namespace App\Services\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface StoreOrderLoggerServiceInterface
{
    public function make(Order $order): void;
}
