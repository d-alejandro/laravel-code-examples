<?php

namespace App\UseCases\AdminPanel\Order;

use App\DTO\AdminPanel\Order\IndexOrderRequestDTO;
use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;
use App\Repositories\AdminPanel\Order\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\AdminPanel\Order\Interfaces\IndexOrderUseCaseInterface;
use App\UseCases\AdminPanel\Order\Exceptions\OrderSearchException;
use Throwable;

class IndexOrderUseCase implements IndexOrderUseCaseInterface
{
    public function __construct(
        private OrderSearchRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderSearchException
     */
    public function execute(IndexOrderRequestDTO $indexOrderRequestDTO): IndexOrderResponseDTO
    {
        try {
            return $this->repository->make($indexOrderRequestDTO);
        } catch (Throwable $exception) {
            throw new OrderSearchException('An error occurred while loading orders.', previous: $exception);
        }
    }
}
