<?php

namespace App\DTO;

use App\Enums\SortTypeEnum;
use App\Models\Enums\Interfaces\ModelColumnInterface;

readonly class IndexPaginationDTO
{
    public function __construct(
        public int                  $start,
        public int                  $end,
        public ModelColumnInterface $sortColumn,
        public SortTypeEnum         $sortType,
        public array|null           $ids = null
    ) {
    }
}
