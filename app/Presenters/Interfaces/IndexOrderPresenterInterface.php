<?php

namespace App\Presenters\Interfaces;

use App\DTO\IndexOrderResponseDTO;

interface IndexOrderPresenterInterface
{
    public function present(IndexOrderResponseDTO $indexOrderResponseDTO): mixed;
}
