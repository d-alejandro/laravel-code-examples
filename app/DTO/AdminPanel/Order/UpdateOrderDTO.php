<?php

namespace App\DTO\AdminPanel\Order;

use App\Models\Order;

class UpdateOrderDTO
{
    public function __construct(private Order $order, private array $columns)
    {
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}
