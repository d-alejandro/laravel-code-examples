<?php

namespace App\Repositories\Criteria;

use App\Enums\SortTypeEnum;
use App\Models\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class PaginationCriterion implements CriterionInterface
{
    public function __construct(
        private string               $table,
        private ModelColumnInterface $sortColumn,
        private SortTypeEnum         $sortType,
        private int                  $start,
        private int                  $end
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->orderBy("$this->table.{$this->sortColumn->value}", $this->sortType->value)
            ->skip($this->start)
            ->take($this->end - $this->start);
    }
}
