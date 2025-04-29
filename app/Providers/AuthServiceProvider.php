<?php

namespace App\Providers;

use App\Models\Comment;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * السياسات الخاصة بالموديلات.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * تسجيل أي خدمات مصادقة / سياسة.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // Gate::define('manage-posts', function ($user) {
        //     return $user->hasRole('admin');
        // });
    }
}
