<?php

namespace App\Events;

use App\Events\Interfaces\EventInterface;
use App\Models\Order;

readonly class OrderStored implements EventInterface
{
    public function __construct(
        public Order $order
    ) {
    }
}
