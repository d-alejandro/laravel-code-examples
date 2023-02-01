<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class SelectCriterion implements CriterionInterface
{
    public function __construct(
        private mixed $columns
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->select($this->columns);
    }
}
