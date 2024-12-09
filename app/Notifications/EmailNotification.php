<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $data = null, public $token = null, public $user = null)
    {

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
        \Log::info($this->data['url']);
        $template = 'mail.template';
        $btnLink = URL::route($this->data['url'], ['token' => $this->token, 'email' => $this->user->email]);

        $mail = (new MailMessage)
            ->subject($this->data['subject'])
            ->greeting($this->data['greeting']);

        // Add lines from the data array
        foreach ($this->data['line'] as $line) {
            $mail->line($line);
        }

        $mail->markdown($template, ['url' => ($btnLink), 'wording' => $this->data['wording']]);

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
            'user' => $this->user,
        ];
    }
}
