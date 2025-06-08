<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RoleChangedNotification extends Notification
{
    use Queueable;

    protected string $newRole;

    public function __construct(string $newRole)
    {
        $this->newRole = $newRole;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'role_changed',
            'message' => '📌 تم تغيير دورك إلى: "' . $this->getRoleNameArabic($this->newRole) . '"',
            'new_role' => $this->newRole,
        ];
    }

    protected function getRoleNameArabic($role)
    {
        return match ($role) {
            'super-admin' => 'سوبر أدمن',
            'admin' => 'مشرف',
            'user' => 'مستخدم',
            default => $role,
        };
    }
}
