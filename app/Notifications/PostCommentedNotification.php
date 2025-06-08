<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PostCommentedNotification extends Notification
{
    use Queueable;

    public function __construct(public Post $post) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'قام ' . Auth::user()->name . ' بالتعليق على مقالك: ' . $this->post->title,
            'post_id' => $this->post->id,
        ];
    }
}
