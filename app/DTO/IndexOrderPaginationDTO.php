<?php

namespace App\DTO;

use App\Enums\OrderSortColumnEnum;
use App\Enums\SortTypeEnum;

readonly class IndexOrderPaginationDTO
{
    public function __construct(
        public int                 $start,
        public int                 $end,
        public OrderSortColumnEnum $sortColumn,
        public SortTypeEnum        $sortType,
        public array|null          $ids = null
    ) {
    }
}
