<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $post;
    
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new post titled "' . $this->post->title . '" has been submitted.')
                    ->action('Review Post', url('/admin/dashboard'))
                    ->line('Thank you for helping keep our community engaged!');
    }
    
    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'title'   => $this->post->title,
        ];
    }
}
