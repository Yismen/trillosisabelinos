<?php

namespace App\Enums;

use App\Enums\Contracts\EnumContract;

enum RegistrationStatusEnum: int implements EnumContract
{
    case Pending = 1;
    case Paid = 2;

    use \App\Enums\Traits\AsEnum;
}
