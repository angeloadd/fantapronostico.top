<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Auth\Controllers;

use Tests\Feature\Modules\Auth\Helpers\UserAuthTrait;
use Tests\TestCase;

final class LogoutAction extends TestCase
{
    use UserAuthTrait;

    public function test_a_user_can_logout(): void
    {
        $this->loginUser();
        $response = $this->delete('logout');
        $response->assertRedirect();
        $this->assertNull(auth()->user());
    }
}
