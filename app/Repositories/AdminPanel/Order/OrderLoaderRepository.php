<?php

namespace App\Repositories\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\Repositories\Query\ExpressionBuilderInterface;

class OrderLoaderRepository implements OrderLoaderRepositoryInterface
{
    public function __construct(private ExpressionBuilderInterface $expressionBuilder)
    {
    }

    /**
     * @return Order|\Illuminate\Database\Eloquent\Model
     */
    public function make(int $id): Order
    {
        return $this->expressionBuilder->findOrFail($id);
    }
}
