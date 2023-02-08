<?php

namespace App\DTO;

use App\DTO\Interfaces\OrderResponseDTOInterface;
use App\Models\Order;

readonly class OrderResponseDTO implements OrderResponseDTOInterface
{
    public function __construct(
        public Order $order
    ) {
    }
}
