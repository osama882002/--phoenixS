<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

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
        // return [
        //     'title' => $this->post->title,
        //     'author' => $this->post->user->name,
        //     'post_id' => $this->post->id,
        //     'status' => 'pending', // لإظهار زر القبول والرفض
        //     'message' => 'مقال جديد بانتظار المراجعة: ' . $this->post->title,
        //     'url' => route('admin.posts.review') // إضافة رابط المراجعة

        // ];
            return [
        'type' => 'post_submission',
        'title' => 'تم إرسال مقال جديد',
        'message' => $this->post->user->name . ' أرسل مقالًا جديدًا بعنوان "' . Str::limit($this->post->title, 50) . '" للمراجعة.',
        'post_id' => $this->post->id,
        'user_id' => $this->post->user_id,
        'url' => route('admin.posts.review'), // إضافة رابط المراجعة
        'status' => 'pending', // لإظهار زر القبول والرفض

    ];
    }
}
