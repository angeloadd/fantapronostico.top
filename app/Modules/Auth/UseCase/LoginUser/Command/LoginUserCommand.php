<?php

declare(strict_types=1);

namespace App\Modules\Auth\UseCase\LoginUser\Command;

use App\Shared\CommandHandler\CommandInterface;

final readonly class LoginUserCommand implements CommandInterface
{
    public const EMAIL = 'email';

    public const PASSWORD = 'password';

    public function __construct(public string $email, public string $password)
    {
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            self::EMAIL => $this->email,
            self::PASSWORD => $this->password,
        ];
    }
}
