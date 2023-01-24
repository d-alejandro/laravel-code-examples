<?php

namespace App\Helpers;

use App\Helpers\Exceptions\EnumSerializerException;
use App\Helpers\Interfaces\EnumSerializerHelperInterface;

class EnumSerializerHelperHelper implements EnumSerializerHelperInterface
{
    private const COLUMN_KEY_VALUE = 'value';
    private const SERIALIZE_SEPARATOR = ',';

    /**
     * @throws EnumSerializerException
     */
    public function execute(string $enum): string
    {
        if (enum_exists($enum)) {
            /* @var $enum \UnitEnum */
            $enumCases = $enum::cases();

            $enumValues = $this->getEnumValues($enumCases);

            return $this->serializeEnumValues($enumValues);
        }

        throw new EnumSerializerException('Enum class does not exist.');
    }

    private function getEnumValues(array $enumCases): array
    {
        return array_column($enumCases, self::COLUMN_KEY_VALUE);
    }

    private function serializeEnumValues(array $array): string
    {
        return implode(self::SERIALIZE_SEPARATOR, $array);
    }
}
