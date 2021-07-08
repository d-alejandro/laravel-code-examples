<?php

namespace App\UseCases\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Repositories\AdminPanel\Order\Interfaces\OrdersLoaderRepositoryInterface;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrdersLoadingException;
use Throwable;

class IndexOrderUseCase implements IndexOrderUseCaseInterface
{
    public function __construct(private OrdersLoaderRepositoryInterface $ordersLoaderRepository)
    {
    }

    /**
     * @throws OrdersLoadingException
     */
    public function execute(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        try {
            return $this->ordersLoaderRepository->make($indexOrderRequestDTO);
        } catch (Throwable $exception) {
            throw new OrdersLoadingException('An error occurred while loading orders.', previous: $exception);
        }
    }
}
