<?php

namespace Tests\Unit\Helpers;

use App\Exceptions\SystemException;
use App\Helpers\StringArrayConverter;
use App\Helpers\StringConverter;
use PHPUnit\Framework\TestCase;

class StringArrayConverterTest extends TestCase
{
    private StringArrayConverter $stringArrayConverter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stringArrayConverter = new StringArrayConverter(new StringConverter());
    }

    public function getDataProvider(): array
    {
        return [
            'emptyAttributesAndKeys' => [
                'attributes' => [],
                'keys' => [],
                'expectedResult' => [],
            ],
            'emptyAttributes' => [
                'attributes' => [],
                'keys' => ['testKey'],
                'expectedResult' => [],
            ],
            'emptyKeys' => [
                'attributes' => [
                    'testKey' => 'testValue',
                ],
                'keys' => [],
                'expectedResult' => [
                    'testKey' => 'testValue',
                ],
            ],
            'withTestKeyTrue' => [
                'attributes' => [
                    'testKey' => 'true',
                ],
                'keys' => ['testKey'],
                'expectedResult' => [
                    'testKey' => true,
                ],
            ],
        ];
    }

    public function getDataProviderError(): array
    {
        return [
            'errorTestValue' => [
                'attributes' => [
                    'testKey' => 'test',
                ],
                'keys' => ['testKey'],
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulConvertDataArrayToBoolean(array $attributes, array $keys, array $expectedResult): void
    {
        $result = $this->stringArrayConverter->convertToBooleanByKeys($attributes, $keys);

        $this->assertEqualsCanonicalizing($expectedResult, $result);
    }

    /**
     * @dataProvider getDataProviderError
     */
    public function testFailedConvertDataArrayToBoolean(array $attributes, array $keys): void
    {
        $this->expectException(SystemException::class);

        $this->stringArrayConverter->convertToBooleanByKeys($attributes, $keys);
    }
}
