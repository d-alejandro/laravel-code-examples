<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WhenCriterion implements CriterionInterface
{
    public function __construct(
        private mixed              $value,
        private CriterionInterface $criterion
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->when(isset($this->value), fn() => $this->criterion->apply($query));
    }
}
