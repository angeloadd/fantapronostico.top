<?php

declare(strict_types=1);

namespace App\Enums;

enum SignEnum: string
{
    use HasValues;

    case HOME = 'home';

    case AWAY = 'away';

    case DRAW = 'draw';
}
