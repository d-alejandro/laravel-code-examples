<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Illuminate\Database\Query\Builder;

class WhereLikeExpression extends Expression
{
    public const WHERE_LIKE_CENTER = 'whereLikeCenter';
    public const WHERE_LIKE_LEFT = 'whereLikeLeft';

    public function whereLikeCenter(string $table, string $column, string $value): Builder
    {
        return $this->builder->where("{$table}.{$column}", 'like', "%{$value}%");
    }

    public function whereLikeLeft(string $table, string $column, string $value): Builder
    {
        return $this->builder->where("{$table}.{$column}", 'like', "{$value}%");
    }
}
