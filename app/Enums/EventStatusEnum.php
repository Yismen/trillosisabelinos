<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContract;

enum EventStatusEnum: int implements EnumContract
{
    case Pending = 1;
    case Open = 2;
    case Closed = 3;

    use \App\Enums\Traits\AsEnum;
}
