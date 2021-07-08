<?php

namespace App\Repositories\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface OrderDestroyerRepositoryInterface
{
    public function make(Order $order): Order;
}
