<?php

namespace App\Helpers\Interfaces;

use App\Http\Requests\Enums\Interfaces\RequestParamEnumInterface;

interface RequestFilterHelperInterface
{
    public function checkRequestParam(RequestParamEnumInterface $requestParam): mixed;

    public function filterBooleanRequestParam(RequestParamEnumInterface $requestParam): bool|null;
}
