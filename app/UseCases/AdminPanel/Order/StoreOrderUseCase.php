<?php

namespace App\UseCases\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Events\OrderStored;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Models\Order;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderServiceInterface;
use App\UseCases\AdminPanel\Order\Interfaces\StoreOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderCreationException;
use Throwable;

class StoreOrderUseCase implements StoreOrderUseCaseInterface
{
    public function __construct(
        private StoreOrderServiceInterface $storeOrderService,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws OrderCreationException
     */
    public function execute(StoreOrderRequestDTO $storeOrderRequestDTO): Order
    {
        try {
            $order = $this->storeOrderService->make($storeOrderRequestDTO);

            $this->eventDispatcher->dispatch(new OrderStored($order));

            return $order;
        } catch (Throwable $exception) {
            throw new OrderCreationException('An error occurred while creating the order.', previous: $exception);
        }
    }
}
