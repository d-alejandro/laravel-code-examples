<?php

namespace App\UseCases\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\Interfaces\ShowOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use Throwable;

class ShowOrderUseCase implements ShowOrderUseCaseInterface
{
    public function __construct(private OrderLoaderRepositoryInterface $orderLoaderRepository)
    {
    }

    /**
     * @throws OrderNotFoundException
     */
    public function execute(int $id): Order
    {
        try {
            return $this->orderLoaderRepository->make($id);
        } catch (Throwable $exception) {
            throw new OrderNotFoundException("Order {$id} not found.", previous: $exception);
        }
    }
}
