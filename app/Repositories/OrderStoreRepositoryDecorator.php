<?php

namespace App\Repositories;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;
use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Repositories\Interfaces\OrderStoreRepositoryInterface;
use Illuminate\Support\Facades\DB;

class OrderStoreRepositoryDecorator implements OrderStoreRepositoryInterface
{
    public function __construct(
        private OrderStoreRepositoryInterface $repository
    ) {
    }

    public function make(OrderStoreRequestDTOInterface $requestDTO): OrderResponseDTOInterface
    {
        return DB::transaction(
            fn() => $this->repository->make($requestDTO)
        );
    }
}
