<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class SendVerificationLinkEmailAction
{
    public function __invoke(Request $request): Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new Response(null, 302, ['HX-Location' => route('home')]);
        }

        $request->user()->sendEmailVerificationNotification();

        return new Response(view('components.partials.notifications.toast', ['type' => 'success', 'text' => 'Email mandata con successo'])->render());
    }
}
