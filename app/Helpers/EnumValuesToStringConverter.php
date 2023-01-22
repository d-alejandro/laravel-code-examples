<?php

namespace App\Helpers;

use App\Helpers\Exceptions\EnumValuesToStringConverterException;
use App\Helpers\Interfaces\EnumValuesToStringConverterInterface;

class EnumValuesToStringConverter implements EnumValuesToStringConverterInterface
{
    private const COLUMN_KEY = 'value';

    /**
     * @throws EnumValuesToStringConverterException
     */
    public function execute(string $enum): string
    {
        if (enum_exists($enum)) {
            /* @var $enum \UnitEnum */
            $enumCases = $enum::cases();

            $enumValues = $this->getValuesFromEnumCases($enumCases);

            return $this->convertEnumValuesToString($enumValues);
        }

        throw new EnumValuesToStringConverterException('Enum class does not exist.');
    }

    private function getValuesFromEnumCases(array $enumCases): array
    {
        return array_column($enumCases, self::COLUMN_KEY);
    }

    private function convertEnumValuesToString(array $array): string
    {
        return implode(',', $array);
    }
}
