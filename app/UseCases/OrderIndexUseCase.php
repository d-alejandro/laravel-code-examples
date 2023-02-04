<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;
use App\DTO\Interfaces\OrderIndexResponseDTOInterface;
use App\Repositories\Interfaces\OrderSearchRepositoryInterface;
use App\UseCases\Exceptions\OrderSearchUseCasesException;
use App\UseCases\Interfaces\OrderIndexUseCaseInterface;
use Throwable;

class OrderIndexUseCase implements OrderIndexUseCaseInterface
{
    public function __construct(
        private OrderSearchRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderSearchUseCasesException
     */
    public function execute(OrderIndexRequestDTOInterface $requestDTO): OrderIndexResponseDTOInterface
    {
        try {
            return $this->repository->make($requestDTO);
        } catch (Throwable $exception) {
            throw new OrderSearchUseCasesException('An error occurred while loading orders.', previous: $exception);
        }
    }
}
