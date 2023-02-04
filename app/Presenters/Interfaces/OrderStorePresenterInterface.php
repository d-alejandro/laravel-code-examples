<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\OrderStoreResponseDTOInterface;

interface OrderStorePresenterInterface
{
    public function present(OrderStoreResponseDTOInterface $responseDTO): mixed;
}
