<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\PostReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReplyToPost extends Notification
{
    use Queueable;

    public $postReply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PostReply $postReply)
    {
        $this->postReply = $postReply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $post = Post::findOrFail($this->postReply->post_id);
        if ($post->user->reply_email_notification) {
            return ['mail', 'database'];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('There is a new reply to your post:')
            ->action('Show Reply', route('posts.show', $this->postReply->post_id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'postReply' => $this->postReply,
        ];
    }
}
