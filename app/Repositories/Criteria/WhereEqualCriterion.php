<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhereEqualCriterion implements CriterionInterface
{
    public function __construct(
        private string $table,
        private string $column,
        private mixed  $value
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->where("$this->table.$this->column", $this->value);
    }
}
