<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Illuminate\Database\Query\Builder;

class WhereEqualExpression extends Expression
{
    public const WHERE_EQUAL = 'whereEqual';

    public function whereEqual(string $table, string $column, mixed $value): Builder
    {
        return $this->builder->where("{$table}.{$column}", $value);
    }
}
