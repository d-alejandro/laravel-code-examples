<?php

namespace App\Repositories\Criteria;

use App\Models\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhereDateLessThanOrEqualCriterion implements CriterionInterface
{
    public function __construct(
        private string               $table,
        private ModelColumnInterface $column,
        private string|null          $date
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->whereRaw(
            "date_format(`$this->table`.`{$this->column->value}`, '%Y-%m-%d 00:00:00') <= "
            . "str_to_date(?, '%Y-%m-%d 00:00:00')",
            [$this->date]
        );
    }
}
