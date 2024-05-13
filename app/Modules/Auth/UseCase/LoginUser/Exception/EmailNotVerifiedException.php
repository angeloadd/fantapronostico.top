<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\LoginUser\Exception;

use Illuminate\Http\RedirectResponse;
use RuntimeException;

final class EmailNotVerifiedException extends RuntimeException
{
    public static function create(): self
    {
        return new self('Email is not verified yet.', 403);
    }

    public function render(): RedirectResponse
    {
        return redirect()->to(route('verify-email'));
    }
}
