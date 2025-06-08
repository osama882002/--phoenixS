<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;

class RoleUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user, public string $newRole) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'تم تحديث دور المستخدم: ' . $this->user->name . ' إلى ' . $this->newRole,
            'user_id' => $this->user->id,
            'new_role' => $this->newRole,
        ];
    }
}
