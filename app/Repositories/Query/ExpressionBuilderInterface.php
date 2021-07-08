<?php

namespace App\Repositories\Query;

interface ExpressionBuilderInterface
{
    public function __call(string $method, array $parameters): mixed;
}
