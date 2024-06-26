<?php

namespace App\Service\RequestProvider;

use Illuminate\Http\Request;

interface RequestProviderServiceInterface
{
    public function request(): Request;
}
