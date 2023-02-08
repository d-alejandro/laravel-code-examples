<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\DTO\Interfaces\OrderIndexResponseDTOInterface;
use App\Repositories\Interfaces\OrderIndexRepositoryInterface;
use App\UseCases\Exceptions\OrderIndexUseCasesException;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use Throwable;

class OrderIndexUseCase implements OrderIndexUseCaseInterface
{
    public function __construct(
        private OrderIndexRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderIndexUseCasesException
     */
    public function execute(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTOInterface
    {
        try {
            return $this->repository->make($requestDTO);
        } catch (Throwable $exception) {
            throw new OrderIndexUseCasesException('An error occurred while loading orders.', previous: $exception);
        }
    }
}
