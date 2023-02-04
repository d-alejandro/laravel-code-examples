<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderStoreResponseDTOInterface;
use App\Models\Order;

readonly class OrderStoreResponseDTO implements OrderStoreResponseDTOInterface
{
    public function __construct(
        public Order $order
    ) {
    }
}
