<?php

namespace App\DTO\AdminPanel\Order;

use App\Models\Agency;

class StoreOrderDTO
{
    public function __construct(private array $columns, private Agency $agency)
    {
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getAgency(): Agency
    {
        return $this->agency;
    }
}
