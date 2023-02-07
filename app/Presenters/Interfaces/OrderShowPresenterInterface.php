<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\OrderShowResponseDTOInterface;

interface OrderShowPresenterInterface
{
    public function present(OrderShowResponseDTOInterface $responseDTO): mixed;
}
