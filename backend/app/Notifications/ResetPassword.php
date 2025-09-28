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
    )
    {
        //
    }

    private function generateUrl(string $token, string $email): string
    {
        // TODO: Should be changed with the link of the vue
        return route('account.reset_password', ['token' => $token, 'email' => $email]);
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
        $resetUrl = $this->generateUrl($this->token, $notifiable->email);

        return (new MailMessage)
            ->subject('Password Reset')
            ->line('Here you can find the link for resetting your password.')
            ->action('Reset Password', url($resetUrl))
            ->line('Thank you for using our application!');
    }
}
