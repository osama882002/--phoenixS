<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostStatusNotification extends Notification implements ShouldQueue
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
        $message = 'Your post "' . $this->post->title . '" has been ';
        $message .= $this->post->status === 'accepted' ? 'approved and published.' : 'rejected.';
        
        return (new MailMessage)
                    ->line($message)
                    ->action('View Post', url('/posts/' . $this->post->id))
                    ->line('Thank you for your contribution!');
    }
    
    public function toArray($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'status'  => $this->post->status,
        ];
    }
}
