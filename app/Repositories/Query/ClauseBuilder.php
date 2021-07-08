<?php

namespace App\Repositories\Query;

use App\Exceptions\SystemException;
use Illuminate\Database\Query\Builder;

/**
 * @method ClauseBuilder whereEqual(string $table, string $column, mixed $value)
 */
class ClauseBuilder
{
    private array $expressionMethods;

    public function __construct(private Builder $builder)
    {
        $this->expressionMethods = config('query-expression-methods');
    }

    /**
     * @throws SystemException
     */
    public function __call(string $method, array $parameters): ClauseBuilder
    {
        if (array_key_exists($method, $this->expressionMethods)) {
            $this->createObjectAndCallMethod($method, $parameters);
            return $this;
        }

        throw new SystemException(sprintf('Call to undefined method %s::%s()', static::class, $method));
    }

    private function createObjectAndCallMethod(string $method, array $parameters): void
    {
        $this->callMethod(new $this->expressionMethods[$method]($this->builder), $method, $parameters);
    }

    private function callMethod(object $object, string $method, array $parameters): void
    {
        $object->{$method}(...$parameters);
    }
}
