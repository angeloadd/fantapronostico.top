<?php

declare(strict_types=1);

namespace App\Enums;

enum GameStatus: string
{
    use HasValues;

    case NOT_STARTED = 'not_started';

    case ONGOING = 'ongoing';

    case FINISHED = 'finished';
}
