<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * تحديد من يمكنه تحديث المقال.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasAnyRole(['admin', 'super-admin']);;
    }

    /**
     * تحديد من يمكنه حذف المقال.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->hasAnyRole(['admin', 'super-admin']);;
    }

    /**
     * تحديد من يمكنه مراجعة المقالات.
     */
    public function review(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super-admin']);;
    }

    /**
     * تحديد من يمكنه الموافقة على المقالات.
     */
    public function approve(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super-admin']);;
    }

    /**
     * تحديد من يمكنه رفض المقالات.
     */
    public function reject(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super-admin']);
    }
    /**
     * التحقق من صلاحية الوصول العام للمراجعة من خلال authorize('review', Post::class)
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'super-admin']);
    }
}
