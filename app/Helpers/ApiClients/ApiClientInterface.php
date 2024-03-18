<?php

declare(strict_types=1);

namespace App\Helpers\ApiClients;

interface ApiClientInterface
{
    public function get(string $uri): array;
}
