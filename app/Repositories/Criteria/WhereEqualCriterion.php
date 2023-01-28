<?php

namespace App\Repositories\Criteria;

use App\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhereEqualCriterion implements CriterionInterface
{
    public function __construct(
        private string               $table,
        private ModelColumnInterface $column,
        private mixed                $value
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->where("$this->table.{$this->column->value}", $this->value);
    }
}
