<?php

namespace App\Constants;

enum InvoicesStatus: string
{
    case PENDING = 'PENDING';
    case COMPLETED = 'COMPLETED';
    case EXPIRED = 'EXPIRED';
    case PENDING_PAYMENT = 'PENDING_PAYMENT';

    public static function getInvoicesStatus(): array
    {
        return array_map(fn ($enum) => $enum->value, self::cases());
    }
}
