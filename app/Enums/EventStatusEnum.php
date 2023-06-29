<?php

namespace App\Enums;

enum EventStatusEnum: int
{
    case Pending = 1;
    case Open = 2;
    case Closed = 3;

    public static function toArray(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
