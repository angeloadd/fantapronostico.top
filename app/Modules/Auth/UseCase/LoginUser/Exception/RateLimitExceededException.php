<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\LoginUser\Exception;

use Illuminate\Http\RedirectResponse;
use RuntimeException;

final class RateLimitExceededException extends RuntimeException
{
    private string $translationKey;

    private int $seconds;

    public function __construct(string $message, int $seconds)
    {
        parent::__construct($message, 403);
        $this->seconds = $seconds;
    }

    public static function create(int $seconds): self
    {
        return new self('auth.throttle', $seconds);
    }

    public function render(): RedirectResponse
    {
        return back()->withErrors(
            [
                'rate' => trans(
                    $this->getMessage(),
                    [
                        'seconds' => $this->seconds,
                        'minutes' => ceil($this->seconds / 60),
                    ]
                ),
            ]
        );
    }
}
