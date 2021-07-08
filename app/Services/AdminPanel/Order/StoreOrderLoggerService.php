<?php

namespace App\Services\AdminPanel\Order;

use App\Models\Order;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderLoggerServiceInterface;
use Log;

class StoreOrderLoggerService implements StoreOrderLoggerServiceInterface
{
    public function make(Order $order): void
    {
        Log::info("Order added \n", [
            '__order__' => print_r($order->toArray(), true),
        ]);
    }
}
