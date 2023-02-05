<?php

namespace Tests\Unit\Helper;

use App\Helpers\Exceptions\BooleanFilterHelperException;
use App\Helpers\RequestFilterHelper;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Helper\Preconditions\TestRequestParamEnum;

class RequestFilterHelperTest extends TestCase
{
    public function getDataProvider(): array
    {
        return [
            'withNotNullRequestParam' => [
                'requestParams' => [
                    TestRequestParamEnum::TestKey->value => 'testValue',
                ],
                'expectedResult' => 'testValue',
            ],
            'withNullRequestParam' => [
                'requestParams' => [],
                'expectedResult' => null,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulCheckRequestParam(array $requestParams, mixed $expectedResult): void
    {
        $requestFilterHelper = new RequestFilterHelper($requestParams);

        $result = $requestFilterHelper->checkRequestParam(TestRequestParamEnum::TestKey);

        $this->assertEquals($expectedResult, $result);
    }

    public function getBooleanDataProvider(): array
    {
        return [
            'trueRequestParam' => [
                'requestParams' => [
                    TestRequestParamEnum::TestKey->value => 'true',
                ],
                'expectedResult' => true,
            ],
            'falseRequestParam' => [
                'requestParams' => [
                    TestRequestParamEnum::TestKey->value => 'false',
                ],
                'expectedResult' => false,
            ],
            'withNullRequestParam' => [
                'requestParams' => [],
                'expectedResult' => null,
            ],
        ];
    }

    /**
     * @dataProvider getBooleanDataProvider
     * @throws BooleanFilterHelperException
     */
    public function testSuccessfulFilterBooleanRequestParam(array $requestParams, mixed $expectedResult): void
    {
        $requestFilterHelper = new RequestFilterHelper($requestParams);

        $result = $requestFilterHelper->filterBooleanRequestParam(TestRequestParamEnum::TestKey);

        $this->assertEquals($expectedResult, $result);
    }

    public function testFailedFilterBooleanRequestParam(): void
    {
        $this->expectException(BooleanFilterHelperException::class);

        $requestFilterHelper = new RequestFilterHelper([TestRequestParamEnum::TestKey->value => 'test']);

        $requestFilterHelper->filterBooleanRequestParam(TestRequestParamEnum::TestKey);
    }
}
