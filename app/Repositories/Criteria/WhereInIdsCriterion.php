<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhereInIdsCriterion implements CriterionInterface
{
    public function __construct(
        private string     $table,
        private array|null $ids
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->whereIn("$this->table.id", array_map('intval', $this->ids));
    }
}
