<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPostSubmitted extends Notification
{
    use Queueable;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database']; // أو 'mail' أيضاً لو حبيت
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->post->title,
            'author' => $this->post->user->name,
            'post_id' => $this->post->id,
            'status' => 'pending', // لإظهار زر القبول والرفض
            'message' => 'مقال جديد بانتظار المراجعة: ' . $this->post->title,
        ];
    }
}
