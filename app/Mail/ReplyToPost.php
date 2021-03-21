<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyToPost extends Mailable
{
    use Queueable, SerializesModels;

    protected $replyContent;
    protected $replyUsername;
    protected $postUsername;
    protected $postTitle;
    protected $postContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($replyContent, $replyUsername, $postUsername, $postTitle, $postContent)
    {
        $this->replyContent = $replyContent;
        $this->replyUsername = $replyUsername;
        $this->postUsername = $postUsername;
        $this->postTitle = $postTitle;
        $this->postContent = $postContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM'))->subject('New Reply to your Post')->view('posts.mailnotification')->with([
            'replyContent' => $this->replyContent,
            'replyUsername' => $this->replyUsername,
            'postUsername' => $this->postUsername,
            'postTitle' => $this->postTitle,
            'postContent' => $this->postContent
        ]);
    }
}
