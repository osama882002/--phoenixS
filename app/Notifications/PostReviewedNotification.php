<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class PostReviewedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Post $post,
        public User $reviewer,
        public string $status // 'approved' or 'rejected'
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'post_reviewed',
            'title' => 'تم ' . ($this->status === 'approved' ? 'الموافقة' : 'رفض') . ' مقال',
            'message' => 'قام ' . $this->reviewer->name . ' ' .
                ($this->status === 'approved' ? 'بالموافقة على' : 'برفض') .
                ' المقال: "' . Str::limit($this->post->body, 50) . '"',
            'post_id' => $this->post->id,
            'reviewer_id' => $this->reviewer->id,
            'url' => route('posts.show', $this->post),
        ];
    }
}
