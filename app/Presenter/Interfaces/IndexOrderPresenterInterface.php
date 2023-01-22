<?php

namespace App\Presenter\Interfaces;

use App\DTO\IndexOrderResponseDTO;

interface IndexOrderPresenterInterface
{
    public function present(IndexOrderResponseDTO $indexOrderResponseDTO): mixed;
}
