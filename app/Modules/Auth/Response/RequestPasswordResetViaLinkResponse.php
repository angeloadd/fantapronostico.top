<?php

declare(strict_types=1);

namespace App\Modules\Auth\Response;

use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse;

final class RequestPasswordResetViaLinkResponse implements RequestPasswordResetLinkViewResponse
{
    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {

    }
}
