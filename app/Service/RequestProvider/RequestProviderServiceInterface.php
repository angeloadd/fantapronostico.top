<?php

declare(strict_types=1);

namespace App\Service\RequestProvider;

use Illuminate\Http\Request;

interface RequestProviderServiceInterface
{
    public function request(): Request;
}
