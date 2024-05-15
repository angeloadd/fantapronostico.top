<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\UseCase\LoginUser\Command\LoginUserCommand;
use App\Modules\Auth\UseCase\LoginUser\Command\LoginUserCommandHandler;
use Illuminate\Http\RedirectResponse;

final readonly class LoginAction
{
    public function __construct(private LoginUserCommandHandler $loginAction)
    {
    }

    public function __invoke(LoginRequest $request): RedirectResponse
    {
        $this->loginAction->handle(
            new LoginUserCommand(
                $request->email(),
                $request->password()
            )
        );

        return redirect()->intended(route('home'));
    }
}
