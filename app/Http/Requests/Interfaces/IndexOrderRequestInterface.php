<?php

namespace App\Http\Requests\Interfaces;

use App\DTO\Interfaces\IndexOrderRequestDTOInterface;

interface IndexOrderRequestInterface
{
    public function rules(): array;

    public function getValidated(): IndexOrderRequestDTOInterface;
}
