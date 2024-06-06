<?php

declare(strict_types=1);

namespace App\Modules\Auth\Enums;

use App\Enums\HasValues;

enum RoleEnum
{
    use HasValues;
    case ADMIN;

    case MOD;
}
