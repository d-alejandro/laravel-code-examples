<?php

namespace App\Repositories\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderDestroyerRepositoryInterface;

class OrderDestroyerRepository implements OrderDestroyerRepositoryInterface
{
    public function make(Order $order): Order
    {
        $order->delete();

        return $order;
    }
}
