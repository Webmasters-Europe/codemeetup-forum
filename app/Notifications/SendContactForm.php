<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendContactForm extends Notification
{
    use Queueable;

    private $contactFormData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contactFormData)
    {
        $this->contactFormData = $contactFormData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        return (new MailMessage)
                    ->subject('Contact from '.config('app.settings.forum_name'))
                    ->line('This is the Message from the Contact-Form:')
                    ->line('################################')
                    ->line('Name: '.$this->contactFormData['name'])
                    ->line('EMail: '.$this->contactFormData['email'])
                    ->line('Message:'.$this->contactFormData['message'])
                    ->line('################################');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
