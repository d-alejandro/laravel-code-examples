<?php

namespace App\Helpers;

use App\Helpers\Exceptions\EnumHelperException;
use App\Helpers\Interfaces\EnumHelperInterface;

class EnumHelper implements EnumHelperInterface
{
    public const SERIALIZE_SEPARATOR = ',';
    private const COLUMN_KEY_VALUE = 'value';

    /**
     * @throws EnumHelperException
     */
    public function getValues(string $enum): array
    {
        $enumCases = $this->getEnumCasesIfExists($enum);
        return array_column($enumCases, self::COLUMN_KEY_VALUE);
    }

    /**
     * @throws EnumHelperException
     */
    public function serialize(string $enum): string
    {
        $enumValues = $this->getValues($enum);
        return implode(self::SERIALIZE_SEPARATOR, $enumValues);
    }

    /**
     * @throws EnumHelperException
     */
    private function getEnumCasesIfExists(string $enum): array
    {
        if (enum_exists($enum)) {
            /* @var $enum \UnitEnum */
            return $enum::cases();
        }
        throw new EnumHelperException('Enum class does not exist.');
    }
}
