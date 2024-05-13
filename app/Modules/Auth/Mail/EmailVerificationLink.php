<?php

declare(strict_types=1);

namespace App\Modules\Auth\Mail;

use App\Modules\Auth\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

final class EmailVerificationLink extends Mailable
{
    use Queueable, SerializesModels;

    private string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly User $user)
    {
        $validityIntervalInMinutes = Config::get('auth.verification.expire', 60);
        $this->url = URL::temporarySignedRoute(
            'email.verified',
            60 * (is_int($validityIntervalInMinutes) ? $validityIntervalInMinutes : 60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->user->email],
            subject: 'Verifica la tua mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mails.email-verification-link',
            with: [
                'url' => $this->url,
                'user' => $this->user,
            ]
        );
    }
}
