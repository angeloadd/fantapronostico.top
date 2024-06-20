<?php

declare(strict_types=1);

namespace App\Shared\Response;

interface ViewDtoInterface
{
    public function getView(): string;
}
