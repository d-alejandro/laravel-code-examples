<?php

namespace App\Repositories\Query;

use Illuminate\Database\Eloquent\Builder;

/**
 * @method ExpressionBuilder whereEqual(string $table, string $column, mixed $value)
 * @method ExpressionBuilder with(array|string $array)
 * @method ExpressionBuilder select(array|string $columns = ['*'])
 * @method ExpressionBuilder joinClause(string $joinTable, string $joinAlias, string $joinColumn, string $table, string $column, \Closure $whereClosure = null)
 * @method \Illuminate\Database\Eloquent\Model getModel()
 * @method \Illuminate\Database\Eloquent\Model findOrFail(int $id, array $columns = ['*'])
 * @method \Illuminate\Database\Eloquent\Model firstOrCreate(array $attributes = [], array $values = [])
 * @method \Illuminate\Database\Eloquent\Collection get(array|string $columns = ['*'])
 * @method int count(string $columns = '*')
 * @method ExpressionBuilder pagination(string $table, string $column, string $order, int $start, int $end)
 * @method ExpressionBuilder whereInIds(string $table, int[] $array)
 * @method ExpressionBuilder whereDateBetween(string $table, string $column, string $startDate, string $endDate)
 * @method ExpressionBuilder whereDateEqual(string $table, string $column, string $date)
 * @method ExpressionBuilder whereDateGreaterThanOrEqual(string $table, string $column, string $date)
 * @method ExpressionBuilder whereDateLessThanOrEqual(string $table, string $column, string $date)
 * @method ExpressionBuilder whereLikeCenter(string $table, string $column, string $value)
 * @method ExpressionBuilder whereLikeLeft(string $table, string $column, mixed $value)
 * @method ExpressionBuilder whereNull(string|array $columns, string $boolean = 'and', bool $not = false)
 */
class ExpressionBuilder implements ExpressionBuilderInterface
{
    private Builder $builder;

    private array $expressionMethods;

    public function __construct(string $model)
    {
        /**
         * @var \Illuminate\Database\Eloquent\Model $model
         */
        $this->builder = $model::query();

        $this->expressionMethods = config('query-expression-methods');
    }

    public function __call(string $method, array $parameters): mixed
    {
        if (array_key_exists($method, $this->expressionMethods)) {
            $this->createObjectAndCallMethod($method, $parameters);
            return $this;
        }

        $response = $this->callMethod($this->builder, $method, $parameters);

        if ($response instanceof Builder) {
            return $this;
        }

        return $response;
    }

    private function createObjectAndCallMethod(string $method, array $parameters): void
    {
        $this->callMethod(new $this->expressionMethods[$method]($this->builder->getQuery()), $method, $parameters);
    }

    private function callMethod(object $object, string $method, array $parameters): mixed
    {
        return $object->{$method}(...$parameters);
    }
}
