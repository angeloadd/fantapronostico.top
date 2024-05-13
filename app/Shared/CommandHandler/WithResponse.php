<?php

declare(strict_types=1);

namespace App\Shared\CommandHandler;

interface WithResponse
{
    public function response(): CommandResponseInterface;
}
