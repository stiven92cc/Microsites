<?php

namespace App\Constants;

class SubscriptionPeriods
{
    public const DAILY = "daily";
    public const WEEKLY = "weekly";
    public const MONTHLY = "monthly";
    public const YEARLY = "yearly";

    public static function getAllSubscriptionPeriods(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
