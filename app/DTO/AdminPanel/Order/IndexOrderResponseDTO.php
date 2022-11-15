<?php

namespace App\DTO\AdminPanel\Order;

use Illuminate\Database\Eloquent\Collection;

class IndexOrderResponseDTO
{
    public function __construct(
        public readonly Collection $collection,
        public readonly int        $totalRowCount
    ) {
    }
}
