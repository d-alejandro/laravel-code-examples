<?php

namespace App\Repositories\AdminPanel\Order;

use App\DTO\AdminPanel\Order\StoreOrderDTO;
use App\Helpers\Interfaces\SettersFillerInterface;
use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderCreatorRepositoryInterface;

class OrderCreatorRepository implements OrderCreatorRepositoryInterface
{
    public function __construct(private Order $order, private SettersFillerInterface $settersFiller)
    {
    }

    public function make(StoreOrderDTO $storeOrderDTO): Order
    {
        $this->settersFiller->fill(
            $storeOrderDTO->getColumns(),
            $this->order->setters()
        );

        $this->order->setAgency($storeOrderDTO->getAgency());

        $this->order->save();

        return $this->order;
    }
}
