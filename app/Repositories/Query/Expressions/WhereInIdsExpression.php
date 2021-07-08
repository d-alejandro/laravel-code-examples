<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Illuminate\Database\Query\Builder;

class WhereInIdsExpression extends Expression
{
    public const WHERE_IN_IDS = 'whereInIds';

    public function whereInIds(string $table, array $ids): Builder
    {
        return $this->builder->whereIn("{$table}.id", array_map('intval', $ids));
    }
}
