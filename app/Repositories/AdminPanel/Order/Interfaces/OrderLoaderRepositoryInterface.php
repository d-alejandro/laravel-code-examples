<?php

namespace App\Repositories\AdminPanel\Order\Interfaces;

use App\Models\Order;

interface OrderLoaderRepositoryInterface
{
    public function make(int $id): Order;
}
