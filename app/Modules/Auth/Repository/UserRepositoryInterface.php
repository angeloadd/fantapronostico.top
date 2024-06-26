<?php

namespace App\Modules\Auth\Repository;

use App\Modules\Auth\Models\User;

interface UserRepositoryInterface
{
    public function getAuthenticatedUser(): User;
}
