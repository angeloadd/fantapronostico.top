<?php

declare(strict_types=1);

namespace App\Service;

use DateTimeInterface;

interface TimeManagementServiceInterface
{
    public function isGameNotPredictableYet(DateTimeInterface $dateTime): bool;

    public function isGameInThePast(DateTimeInterface $dateTime): bool;

    public function now(): DateTimeInterface;
}
