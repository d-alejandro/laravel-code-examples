<?php

namespace Tests\Unit\Helper;

use App\Enums\Interfaces\RequestParamEnumInterface;

enum TestRequestParamEnum: string implements RequestParamEnumInterface
{
    case TestKey = 'testKey';
}
