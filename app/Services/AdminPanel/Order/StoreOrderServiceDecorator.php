<?php

namespace App\Services\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderRequestDTO;
use App\Models\Order;
use App\Services\AdminPanel\Order\Interfaces\StoreOrderServiceInterface;
use Illuminate\Support\Facades\DB;

class StoreOrderServiceDecorator implements StoreOrderServiceInterface
{
    public function __construct(private StoreOrderServiceInterface $storeOrderService)
    {
    }

    /**
     * @throws \Throwable
     */
    public function make(StoreOrderRequestDTO $storeOrderRequestDTO): Order
    {
        return DB::transaction(
            fn() => $this->storeOrderService->make($storeOrderRequestDTO)
        );
    }
}
