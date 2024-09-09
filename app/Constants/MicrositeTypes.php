<?php

namespace App\Constants;

class MicrositeTypes
{
    public const INVOICE = 'invoice';

    public const SUBSCRIPTION = 'subscription';

    public const DONATION = 'donation';

    public static function getTypes(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }

}
