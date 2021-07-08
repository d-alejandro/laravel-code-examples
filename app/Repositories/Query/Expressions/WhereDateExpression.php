<?php

namespace App\Repositories\Query\Expressions;

use App\Repositories\Query\Expression;
use Illuminate\Database\Query\Builder;

class WhereDateExpression extends Expression
{
    public const WHERE_DATE_BETWEEN = 'whereDateBetween';
    public const WHERE_DATE_EQUAL = 'whereDateEqual';
    public const WHERE_DATE_GREATER_THAN_OR_EQUAL = 'whereDateGreaterThanOrEqual';
    public const WHERE_DATE_LESS_THAN_OR_EQUAL = 'whereDateLessThanOrEqual';

    public function whereDateBetween(string $table, string $column, string $startDate, string $endDate): Builder
    {
        return $this->builder->whereRaw(
            "date_format(`{$table}`.`{$column}`, '%Y-%m-%d 00:00:00') " .
            "between str_to_date(?, '%Y-%m-%d 00:00:00') and str_to_date(?, '%Y-%m-%d 00:00:00')",
            [$startDate, $endDate]
        );
    }

    public function whereDateEqual(string $table, string $column, string $date): Builder
    {
        return $this->whereDate($table, $column, '=', $date);
    }

    public function whereDateGreaterThanOrEqual(string $table, string $column, string $date): Builder
    {
        return $this->whereDate($table, $column, '>=', $date);
    }

    public function whereDateLessThanOrEqual(string $table, string $column, string $date): Builder
    {
        return $this->whereDate($table, $column, '<=', $date);
    }

    private function whereDate(string $table, string $column, string $operation, string $date): Builder
    {
        return $this->builder->whereRaw(
            "date_format(`{$table}`.`{$column}`, '%Y-%m-%d 00:00:00') {$operation} str_to_date(?, '%Y-%m-%d 00:00:00')",
            [$date]
        );
    }
}
