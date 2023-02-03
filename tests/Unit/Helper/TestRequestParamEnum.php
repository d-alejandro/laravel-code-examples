<?php

namespace Tests\Unit\Helper;

use App\Http\Requests\Enums\Interfaces\RequestParamEnumInterface;

enum TestRequestParamEnum: string implements RequestParamEnumInterface
{
    case TestKey = 'test_key';
    case TestKeyAdditional = 'test_key_additional';
}
