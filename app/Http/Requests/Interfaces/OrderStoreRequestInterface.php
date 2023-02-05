<?php

namespace App\Http\Requests\Interfaces;

use App\DTO\Interfaces\OrderStoreRequestDTOInterface;

interface OrderStoreRequestInterface
{
    public function rules(): array;

    public function getValidated(): OrderStoreRequestDTOInterface;
}
