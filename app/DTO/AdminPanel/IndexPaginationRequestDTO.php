<?php

namespace App\DTO\AdminPanel;

use App\Enums\SortType;

class IndexPaginationRequestDTO
{
    public function __construct(
        public readonly int      $start,
        public readonly int      $end,
        public readonly string   $sort,
        public readonly SortType $order,
        public readonly ?array   $ids = null
    ) {
    }
}
