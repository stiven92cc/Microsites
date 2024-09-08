<?php

namespace App\Constants;

class DocumentTypes
{
    public const CC = 'CC';

    public const CE = 'CE';

    public const PA = 'PA';

    public const NIT = 'NIT';

    public static function getTypes(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }


}
