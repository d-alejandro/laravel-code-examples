<?php

namespace App\UseCases\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface DestroyOrderUseCaseInterface
{
    public function execute(int $id): Order;
}
