<?php

namespace Tests\Unit\Helpers;

use App\Exceptions\SystemException;
use App\Helpers\StringConverter;
use PHPUnit\Framework\TestCase;

class StringConverterTest extends TestCase
{
    private StringConverter $stringConverter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stringConverter = new StringConverter();
    }

    public function getDataProvider(): array
    {
        return [
            'true' => [
                'input' => 'true',
                'expectedResult' => true,
            ],
            'false' => [
                'input' => 'false',
                'expectedResult' => false,
            ],
        ];
    }

    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulConvertToBoolean(string $input, bool $expectedResult): void
    {
        $result = $this->stringConverter->convertToBoolean($input);

        $this->assertEquals($expectedResult, $result);
    }

    public function testFailedConvertToBoolean(): void
    {
        $this->expectException(SystemException::class);

        $this->stringConverter->convertToBoolean('test');
    }
}
