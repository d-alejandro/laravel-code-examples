<?php

namespace App\DTO;

use App\Enums\OrderSortColumn;
use App\Enums\SortType;

readonly class IndexOrderPaginationDTO
{
    public function __construct(
        public int             $start,
        public int             $end,
        public OrderSortColumn $orderSortColumn,
        public SortType        $sortType,
        public array|null      $ids = null
    ) {
    }
}
