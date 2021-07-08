<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Illuminate\Database\Query\Builder;

class PaginationExpression extends Expression
{
    public const PAGINATION = 'pagination';

    public function pagination(string $table, string $column, string $order, int $start, int $end): Builder
    {
        return $this->builder->orderBy("{$table}.{$column}", $order)
            ->skip($start)
            ->take($end - $start);
    }
}
