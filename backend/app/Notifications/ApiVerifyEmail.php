<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ApiVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    private ?string $redirectUrl;

    public function __construct(?string $redirectUrl = null)
    {
        $this->redirectUrl = $redirectUrl;
    }

    private function generateSignedUrl($notifiable): string
    {
        $hash = sha1($notifiable->getEmailForVerification());
        $id = $notifiable->id;

        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $id, 'hash' => $hash],
        );

        $separator = str_contains($this->redirectUrl, '?') ? '&' : '?';

        return $this->redirectUrl ? $this->redirectUrl . $separator . 'url=' . urlencode($signedUrl) : $signedUrl;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->generateSignedUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email')
            ->line('Thank you for registering. Please verify your email with the following link')
            ->action('Verify Email', $verificationUrl)
            ->line('This link will expire in 60 minutes.')
            ->line('If you did not create an account, no further action is required.');
    }
}

