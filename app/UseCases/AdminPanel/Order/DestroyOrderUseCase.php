<?php

namespace App\UseCases\AdminPanel\Order;

use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderDestroyerRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderDeleteException;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use App\UseCases\AdminPanel\Order\Interfaces\DestroyOrderUseCaseInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class DestroyOrderUseCase implements DestroyOrderUseCaseInterface
{
    public function __construct(
        private OrderLoaderRepositoryInterface $orderLoaderRepository,
        private OrderDestroyerRepositoryInterface $orderDestroyerRepository
    ) {
    }

    /**
     * @throws OrderDeleteException
     * @throws OrderNotFoundException
     */
    public function execute(int $id): Order
    {
        try {
            $order = $this->orderLoaderRepository->make($id);

            return $this->orderDestroyerRepository->make($order);
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                throw new OrderNotFoundException("Order {$id} not found.", previous: $exception);
            }

            throw new OrderDeleteException('Order delete error.', previous: $exception);
        }
    }
}
