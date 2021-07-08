<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Closure;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;

class JoinClauseExpression extends Expression
{
    public const JOIN_CLAUSE = 'joinClause';

    public function joinClause(
        string $joinTable,
        string $joinAlias,
        string $joinColumn,
        string $table,
        string $column,
        Closure $whereClosure = null
    ): Builder {
        return $this->builder->join(
            "{$joinTable} as {$joinAlias}",
            fn(JoinClause $join) => $join->on("{$table}.{$column}", "{$joinAlias}.{$joinColumn}")
            && isset($whereClosure) ? $whereClosure($join) : null
        );
    }
}
