<?php

namespace App\Http\Requests\Interfaces;

use App\DTO\Interfaces\OrderIndexRequestDTOInterface;

interface OrderIndexRequestInterface
{
    public function rules(): array;

    public function getValidated(): OrderIndexRequestDTOInterface;
}
