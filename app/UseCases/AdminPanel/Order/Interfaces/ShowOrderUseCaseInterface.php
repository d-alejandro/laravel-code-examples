<?php

namespace App\UseCases\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface ShowOrderUseCaseInterface
{
    public function execute(int $id): Order;
}
