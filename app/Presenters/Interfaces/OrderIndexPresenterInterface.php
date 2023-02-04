<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\OrderIndexResponseDTOInterface;

interface OrderIndexPresenterInterface
{
    public function present(OrderIndexResponseDTOInterface $responseDTO): mixed;
}
