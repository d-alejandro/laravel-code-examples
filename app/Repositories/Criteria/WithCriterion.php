<?php

namespace App\Repositories\Criteria;

use App\Repositories\Criteria\Interfaces\CriterionInterface;
use Illuminate\Contracts\Database\Query\Builder;

class WithCriterion implements CriterionInterface
{
    public function __construct(
        private array|string $relations
    ) {
    }

    public function apply(Builder $query): void
    {
        $query->with($this->relations);
    }
}
