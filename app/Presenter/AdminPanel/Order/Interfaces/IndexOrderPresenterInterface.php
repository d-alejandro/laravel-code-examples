<?php

namespace App\Presenter\AdminPanel\Order\Interfaces;

use App\DTO\AdminPanel\Order\IndexOrderResponseDTO;

interface IndexOrderPresenterInterface
{
    public function present(IndexOrderResponseDTO $indexOrderResponseDTO): mixed;
}
