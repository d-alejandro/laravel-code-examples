<?php

namespace App\DTO;

use App\Enums\SortTypeEnum;
use App\Models\Enums\OrderColumn;

readonly class IndexOrderPaginationDTO
{
    public function __construct(
        public int          $start,
        public int          $end,
        public OrderColumn  $sortColumn,
        public SortTypeEnum $sortType,
        public array|null   $ids = null
    ) {
    }
}
