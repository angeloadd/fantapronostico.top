<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Tournament;
use DateTimeImmutable;
use DateTimeInterface;

final class TimeManagementService implements TimeManagementServiceInterface
{
    private const TWENTY_FOUR_HOURS_IN_SECONDS = 60 * 60 * 24;

    private DateTimeImmutable $now;

    public function __construct()
    {
        $this->now = new DateTimeImmutable();
    }

    public function isGameInThePast(DateTimeInterface $dateTime): bool
    {
        return $this->now->getTimestamp() > $dateTime->getTimestamp();
    }

    public function isGameNotPredictableYet(DateTimeInterface $dateTime): bool
    {
        $daySpan = self::TWENTY_FOUR_HOURS_IN_SECONDS;
        if (Tournament::first()?->started_at->equalTo($dateTime)) {
            $daySpan *= 2;
        }

        $now = $this->now()->getTimestamp();

        return $dateTime->getTimestamp() > $now &&
            $daySpan < ($dateTime->getTimestamp() - $now);
    }

    public function now(): DateTimeInterface
    {
        return $this->now;
    }
}
