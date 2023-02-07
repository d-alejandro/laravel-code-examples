<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderShowResponseDTOInterface;
use App\Repositories\Interfaces\OrderShowRepositoryInterface;
use App\UseCases\Exceptions\OrderNotFoundException;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use Throwable;

class OrderShowUseCase implements OrderShowUseCaseInterface
{
    public function __construct(
        private OrderShowRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderNotFoundException
     */
    public function execute(int $id): OrderShowResponseDTOInterface
    {
        try {
            return $this->repository->make($id);
        } catch (Throwable $exception) {
            throw new OrderNotFoundException("Order $id not found.", previous: $exception);
        }
    }
}
