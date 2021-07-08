<?php

namespace App\Repositories\AdminPanel\Order;

use App\DTO\AdminPanel\Order\UpdateOrderDTO;
use App\Helpers\Interfaces\SettersFillerInterface;
use App\Models\Order;
use App\Repositories\AdminPanel\Order\Interfaces\OrderUpdaterRepositoryInterface;

class OrderUpdaterRepository implements OrderUpdaterRepositoryInterface
{
    public function __construct(private SettersFillerInterface $settersFiller)
    {
    }

    public function make(UpdateOrderDTO $updateOrderDTO): Order
    {
        $order = $updateOrderDTO->getOrder();

        $this->settersFiller->fill(
            $updateOrderDTO->getColumns(),
            $order->setters()
        );

        $order->save();

        return $order;
    }
}
