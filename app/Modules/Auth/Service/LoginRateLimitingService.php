<?php

declare(strict_types=1);

namespace App\Modules\Auth\Service;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final readonly class LoginRateLimitingService implements RateLimiterInterface
{
    public function __construct(private RateLimiter $limiter, private Dispatcher $dispatcher, private Request $request)
    {
    }

    public function attempts(): int
    {
        $attempts = $this->limiter->attempts($this->throttleKey());

        return is_int($attempts) ? $attempts : 0;
    }

    public function tooManyAttempts(): bool
    {
        $tooManyAttempts = $this->limiter->tooManyAttempts($this->throttleKey(), 5);

        if($tooManyAttempts){
            $this->dispatcher->dispatch(new Lockout($this->request));
        }

        return $tooManyAttempts;
    }

    public function increment(): void
    {
        $this->limiter->hit($this->throttleKey());
    }

    public function availableInSeconds(): int
    {
        return $this->limiter->availableIn($this->throttleKey());
    }

    public function clear(): void
    {
        $this->limiter->clear($this->throttleKey());
    }

    public function throttleKey(): string
    {
        $email = $this->request->input('email');

        return Str::transliterate((is_string($email) ? strtolower($email) . '|' : '') . $this->request->ip());
    }
}
