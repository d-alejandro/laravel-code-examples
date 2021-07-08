<?php

namespace App\Presenter\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface OrderPresenterInterface
{
    public function present(Order $order): mixed;
}
