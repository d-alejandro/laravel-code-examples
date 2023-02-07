<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\OrderResponseDTOInterface;

interface OrderPresenterInterface
{
    public function present(OrderResponseDTOInterface $responseDTO): mixed;
}
