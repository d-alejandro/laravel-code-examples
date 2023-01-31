<?php

namespace App\Repositories\Criteria;

use App\Models\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhereNullCheckNotCriterion implements CriterionInterface
{
    public function __construct(
        private string               $table,
        private ModelColumnInterface $column,
        private bool|null            $value
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->whereNull(
            columns: "$this->table.{$this->column->value}",
            not: $this->value
        );
    }
}
