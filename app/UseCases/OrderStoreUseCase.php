<?php

namespace App\UseCases;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderStoreResponseDTOInterface;
use App\Events\OrderStored;
use App\Helpers\Interfaces\EventDispatcherInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use App\UseCases\Exceptions\OrderStoreException;
use App\UseCases\Interfaces\OrderStoreUseCaseInterface;
use Throwable;

class OrderStoreUseCase implements OrderStoreUseCaseInterface
{
    public function __construct(
        private OrderStoreRepositoryInterface $repository,
        private EventDispatcherInterface      $dispatcher
    ) {
    }

    /**
     * @throws OrderStoreException
     */
    public function execute(OrderStoreRequestDTOInterface $requestDTO): OrderStoreResponseDTOInterface
    {
        try {
            $response = $this->repository->make($requestDTO);

            $event = new OrderStored($response->order);
            $this->dispatcher->dispatch($event);

            return $response;
        } catch (Throwable $exception) {
            throw new OrderStoreException('An error occurred while creating the order.', previous: $exception);
        }
    }
}
