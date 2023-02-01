<?php

namespace App\Repositories\Criteria;

use App\Models\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

class JoinAndApplyCriterion implements CriterionInterface
{
    public function __construct(
        private string               $joinTable,
        private string               $joinTableAlias,
        private ModelColumnInterface $joinTableColumn,
        private string               $table,
        private ModelColumnInterface $column,
        private CriterionInterface   $criterion
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->join(
            "$this->joinTable as $this->joinTableAlias",
            function (JoinClause $join) {
                $join->on(
                    "$this->table.{$this->column->value}",
                    "$this->joinTableAlias.{$this->joinTableColumn->value}"
                );
                $this->criterion->apply($join);
            }
        );
    }
}
