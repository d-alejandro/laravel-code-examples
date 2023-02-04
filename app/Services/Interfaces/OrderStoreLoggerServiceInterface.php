<?php

namespace App\Services\Interfaces;

use App\Models\Order;

interface OrderStoreLoggerServiceInterface
{
    public function make(Order $order): void;
}
