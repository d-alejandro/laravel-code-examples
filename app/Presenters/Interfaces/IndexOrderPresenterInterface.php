<?php

namespace App\Presenters\Interfaces;

use App\DTO\Interfaces\IndexOrderResponseDTOInterface;

interface IndexOrderPresenterInterface
{
    public function present(IndexOrderResponseDTOInterface $indexOrderResponseDTO): mixed;
}
