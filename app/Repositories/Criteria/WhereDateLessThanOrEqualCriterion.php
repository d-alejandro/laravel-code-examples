<?php

namespace App\Repositories\Criteria;

use App\Models\Enums\Interfaces\ModelColumnInterface;
use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;

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
        $date = Carbon::parse($this->date)->format('Y-m-d');

        $query->whereDate("$this->table.{$this->column->value}", '<=', $date);
    }
}
