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

    private function generateSignedUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify', // route name
            Carbon::now()->addMinutes(60), // giving expiration time for the url
            ['id' => $notifiable->id, 'hash' => sha1($notifiable->getEmailForVerification())],
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
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
