<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;
use App\Repositories\Interfaces\OrderUpdateRepositoryInterface;
use App\UseCases\Exceptions\OrderUpdateException;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use App\UseCases\Interfaces\OrderUpdateUseCaseInterface;
use Throwable;

class OrderUpdateUseCase implements OrderUpdateUseCaseInterface
{
    public function __construct(
        private OrderShowUseCaseInterface      $showUseCase,
        private OrderUpdateRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderUpdateException
     */
    public function execute(OrderUpdateRequestDTOInterface $requestDTO, int $id): OrderResponseDTOInterface
    {
        try {
            $responseDTO = $this->showUseCase->execute($id);

            $this->repository->make($responseDTO, $requestDTO);

            return $responseDTO;
        } catch (Throwable $exception) {
            throw new OrderUpdateException('Order update error.', previous: $exception);
        }
    }
}
