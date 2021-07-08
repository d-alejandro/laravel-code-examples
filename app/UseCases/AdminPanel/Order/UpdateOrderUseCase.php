<?php

namespace App\UseCases\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderDTO;
use App\DTO\AdminPanel\Order\UpdateOrderRequestDTO;
use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderLoaderRepositoryInterface;
use App\Repositories\AdminPanel\Order\Interfaces\OrderUpdaterRepositoryInterface;
use App\Services\AdminPanel\Order\Interfaces\OrderColumnsCreatorServiceInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderNotFoundException;
use App\UseCases\AdminPanel\Order\Exceptions\OrderUpdateException;
use App\UseCases\AdminPanel\Order\Interfaces\UpdateOrderUseCaseInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class UpdateOrderUseCase implements UpdateOrderUseCaseInterface
{
    public function __construct(
        private OrderLoaderRepositoryInterface $orderLoaderRepository,
        private OrderColumnsCreatorServiceInterface $orderColumnsCreatorService,
        private OrderUpdaterRepositoryInterface $orderUpdaterRepository
    ) {
    }

    /**
     * @throws OrderUpdateException
     * @throws OrderNotFoundException
     */
    public function execute(UpdateOrderRequestDTO $updateOrderRequestDTO, int $id): Order
    {
        try {
            $order = $this->orderLoaderRepository->make($id);

            $columns = $this->orderColumnsCreatorService->make($updateOrderRequestDTO->getProperties());

            $updateOrderDTO = new UpdateOrderDTO($order, $columns);

            return $this->orderUpdaterRepository->make($updateOrderDTO);
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                throw new OrderNotFoundException("Order {$id} not found.", previous: $exception);
            }

            throw new OrderUpdateException('Order update error.', previous: $exception);
        }
    }
}
