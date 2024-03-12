<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
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
    public function __construct(private readonly User $notifiable)
    {
        $validityIntervalInMinutes = Config::get('auth.verification.expire', 60);
        $this->url = URL::temporarySignedRoute(
            'verification.verify',
            60 * (is_int($validityIntervalInMinutes) ? $validityIntervalInMinutes : 60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->notifiable->email],
            subject: 'Verifica la tua mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mails.email-verification-link',
            with: [
                'url' => $this->url,
                'user' => $this->notifiable,
            ]
        );
    }
}
