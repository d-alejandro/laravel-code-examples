<?php

namespace App\Presenters;

use App\DTO\Interfaces\OrderStoreResponseDTOInterface;
use App\Presenters\Interfaces\OrderStorePresenterInterface;

class OrderStorePresenter implements OrderStorePresenterInterface
{
    public function present(OrderStoreResponseDTOInterface $responseDTO): mixed
    {
    }
}
