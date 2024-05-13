<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\LoginUser\Exception;

use Illuminate\Http\RedirectResponse;
use RuntimeException;

final class LoginAttemptFailedException extends RuntimeException
{
    public static function create(): self
    {
        return new self('auth.failed', 500);
    }

    public function render(): RedirectResponse
    {
        return back()->withErrors(['email' => trans($this->getMessage())]);
    }
}
