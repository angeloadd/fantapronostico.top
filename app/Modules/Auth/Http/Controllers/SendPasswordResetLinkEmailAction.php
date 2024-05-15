<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
final class SendPasswordResetLinkEmailAction
{
    public function __invoke(Request $request): Response
    {
        $request->validate(['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT ?
            $this->getResponse('success', 'Email mandata con successo') :
            $this->getResponse('error', 'Email non mandata per ' . $status);
    }

    public function getResponse(string $type, string $message): Response
    {
        return new Response(
            view(
                'components.partials.notifications.toast',
                ['type' => $type, 'text' => $message]
            )->render()
        );
    }
}
