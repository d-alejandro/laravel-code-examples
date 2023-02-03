<?php

namespace Tests\Unit\Helper;

use App\Helpers\EnumHelper;
use App\Helpers\Exceptions\EnumHelperException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Helper\Preconditions\TestRequestParamEnum;

class EnumHelperTest extends TestCase
{
    private EnumHelper $enumHelper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enumHelper = new EnumHelper();
    }

    public function getDataProvider(): array
    {
        return [
            'single' => [
                'input' => TestRequestParamEnum::class,
                'expectedResult' => [
                    TestRequestParamEnum::TestKey->value,
                    TestRequestParamEnum::TestKeyAdditional->value,
                ],
            ]
        ];
    }

    /**
     * @dataProvider getDataProvider
     * @throws EnumHelperException
     */
    public function testSuccessfulGetValues(string $input, array $expectedResult): void
    {
        $result = $this->enumHelper->getValues($input);

        $this->assertEquals($expectedResult, $result);
    }

    public function testFailedGetValues(): void
    {
        $this->expectException(EnumHelperException::class);

        $this->enumHelper->getValues('test');
    }

    public function getDataProviderSerialize(): array
    {
        return [
            'single' => [
                'input' => TestRequestParamEnum::class,
                'expectedResult' => TestRequestParamEnum::TestKey->value
                    . EnumHelper::SERIALIZE_SEPARATOR
                    . TestRequestParamEnum::TestKeyAdditional->value,
            ]
        ];
    }

    /**
     * @dataProvider getDataProviderSerialize
     * @throws EnumHelperException
     */
    public function testSuccessfulSerialize(string $input, string $expectedResult): void
    {
        $result = $this->enumHelper->serialize($input);

        $this->assertEquals($expectedResult, $result);
    }
}
