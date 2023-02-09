<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Repositories\Interfaces\OrderDestroyRepositoryInterface;
use App\UseCases\Exceptions\OrderDestroyException;
use App\UseCases\Interfaces\OrderDestroyUseCaseInterface;
use App\UseCases\Interfaces\OrderShowUseCaseInterface;
use Throwable;

class OrderDestroyUseCase implements OrderDestroyUseCaseInterface
{
    public function __construct(
        private OrderShowUseCaseInterface       $showUseCase,
        private OrderDestroyRepositoryInterface $repository
    ) {
    }

    /**
     * @throws OrderDestroyException
     */
    public function execute(int $id): OrderResponseDTOInterface
    {
        try {
            $responseDTO = $this->showUseCase->execute($id);

            $this->repository->make($responseDTO);

            return $responseDTO;
        } catch (Throwable $exception) {
            throw new OrderDestroyException('Order delete error.', previous: $exception);
        }
    }
}
