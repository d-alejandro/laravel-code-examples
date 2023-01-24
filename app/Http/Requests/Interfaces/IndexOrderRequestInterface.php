<?php

namespace App\Http\Requests\Interfaces;

use App\DTO\IndexOrderRequestDTO;

interface IndexOrderRequestInterface
{
    public function rules(): array;

    public function getValidated(): IndexOrderRequestDTO;
}
