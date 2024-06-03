<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

final class SendVerificationLinkEmailAction
{
    public function __invoke(Request $request): Response
    {
        if ($request->user()->hasVerifiedEmail()) {
            return new Response(null, 302, ['HX-Location' => route('home')]);
        }

        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), [
                'exception' => $e,
            ]);

            return new Response(view('components.partials.notifications.toast', ['type' => 'success', 'text' => 'Qualcosa è andato storto'])->render());
        }
        $request->user()->sendEmailVerificationNotification();

        return new Response(view('components.partials.notifications.toast', ['type' => 'success', 'text' => 'Email mandata con successo'])->render());
    }
}
