<?php

namespace App\Events;

use App\Models\Order;

class OrderStored
{
    public function __construct(private Order $order)
    {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
