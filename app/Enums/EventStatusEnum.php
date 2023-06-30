<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContract;

enum EventStatusEnum: int implements EnumContract
{
    case Open = 1;
    case Closed = 2;

    use \App\Enums\Traits\AsEnum;
}
