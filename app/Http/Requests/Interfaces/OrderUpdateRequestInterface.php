<?php

namespace App\Http\Requests\Interfaces;

use App\DTO\Interfaces\OrderUpdateRequestDTOInterface;

interface OrderUpdateRequestInterface
{
    public function rules(): array;

    public function getValidated(): OrderUpdateRequestDTOInterface;
}
