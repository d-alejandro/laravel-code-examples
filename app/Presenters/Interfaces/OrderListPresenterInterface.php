<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\OrderIndexResponseDTOInterface;

interface OrderListPresenterInterface
{
    public function present(OrderIndexResponseDTOInterface $responseDTO): mixed;
}
