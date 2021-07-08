<?php

namespace App\DTO\AdminPanel\Order;

use Illuminate\Database\Eloquent\Collection;

class IndexOrderResponseDTO
{
    public function __construct(private Collection $collection, private int $totalRowCount)
    {
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function getTotalRowCount(): int
    {
        return $this->totalRowCount;
    }
}
