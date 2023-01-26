<?php

namespace App\Repositories\Criteria\Interfaces;

use Illuminate\Contracts\Database\Query\Builder;

interface CriterionInterface
{
    public function apply(Builder $query): void;
}
