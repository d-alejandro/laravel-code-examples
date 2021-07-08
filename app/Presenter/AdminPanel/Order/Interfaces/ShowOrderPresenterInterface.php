<?php

namespace App\Presenter\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface ShowOrderPresenterInterface
{
    public function present(Order $order): mixed;
}
