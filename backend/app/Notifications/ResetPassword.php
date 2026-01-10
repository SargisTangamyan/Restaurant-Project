<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly string $token,
        private readonly string $redirect_url,
    )
    {
        //
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
        // We manually build the query string to include token and email
        $queryParams = http_build_query([
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        // Check if the redirect_url already has parameters to use the correct separator
        $separator = str_contains($this->redirect_url, '?') ? '&' : '?';

        $resetUrl = $this->redirect_url . $separator . $queryParams;

        return (new MailMessage)
            ->subject('Password Reset')
            ->line('Here you can find the link for resetting your password jkl.')
            ->action('Reset Password', $resetUrl)
            ->line('This link will allow you to choose a new password.')
            ->line('Thank you for using our application!');
    }
}
