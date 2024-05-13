<?php

declare(strict_types=1);

namespace App\Modules\Auth\Service;

interface RateLimiterInterface
{
    public function attempts(): int;

    public function tooManyAttempts(): bool;

    public function increment(): void;

    public function availableInSeconds(): int;

    public function clear(): void;

    public function throttleKey(): string;
}
