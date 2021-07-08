<?php

namespace App\Repositories\Query;

use Illuminate\Database\Query\Builder;

abstract class Expression
{
    public function __construct(protected Builder $builder)
    {
    }
}
