<?php

namespace App\Constants;

class CurrencyTypes
{
    public const COP = 'COP';

    public const USD = 'USD';

    public static function getTypes(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
