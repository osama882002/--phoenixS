<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReviewController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()?->can('review posts'), 403);

        $pendingPosts = Post::where('status', 'pending')->get();
        return view('admin.review-posts', compact('pendingPosts'));
    }

    public function approve(Post $post)
    {
        abort_unless(Auth::user()?->can('approve posts'), 403);

        $post->update(['status' => 'approved']);
        $post->user->notify(new PostApprovedNotification($post));

        return redirect()->back()->with('success', 'تمت الموافقة على المقال.');
    }

    public function reject(Post $post)
    {
        abort_unless(Auth::user()?->can('reject posts'), 403);

        $post->user->notify(new PostRejectedNotification($post));
        $post->delete();

        return redirect()->back()->with('success', 'تم رفض المقال وحذفه.');
    }
}
