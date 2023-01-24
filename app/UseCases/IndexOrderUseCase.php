<?php

namespace App\UseCases;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;
use App\DTO\Interfaces\IndexOrderResponseDTOInterface;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\Exceptions\OrderSearchException;
use App\UseCases\Interfaces\IndexOrderUseCaseInterface;
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
    public function execute(IndexOrderRequestDTOInterface $indexOrderRequestDTO): IndexOrderResponseDTOInterface
    {
        try {
            return $this->repository->make($indexOrderRequestDTO);
        } catch (Throwable $exception) {
            throw new OrderSearchException('An error occurred while loading orders.', previous: $exception);
        }
    }
}
