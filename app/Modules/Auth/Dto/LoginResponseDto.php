<?php

declare(strict_types=1);

namespace App\Modules\Auth\Dto;

final readonly class LoginResponseDto
{
    public function __construct(public array $errors = [], public bool $hasToVerifyEmail = false)
    {
    }
}
