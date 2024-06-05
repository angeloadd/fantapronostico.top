<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;
use DateTimeInterface;

final class FormatDate
{
    public function fnow(): string
    {
        return now()->format(Constants::DISPLAY);
    }

    public function fdate(DateTimeInterface|string $time): string
    {
        return (is_string($time) ? new Carbon($time) : $time)->format(Constants::DISPLAY);
    }
}
