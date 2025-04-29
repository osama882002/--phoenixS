<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostReviewController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('review', Post::class);

        $pendingPosts = Post::where('status', 'pending')->get();
        return view('admin.review-posts', compact('pendingPosts'));
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', $post);
    
        $post->update(['status' => 'approved']);
    
        // إرسال إشعار للمستخدم
        $post->user->notify(new PostApprovedNotification($post));
    
        return redirect()->back()->with('success', 'تمت الموافقة على المقال.');
    }
    

    public function reject(Post $post)
{
    $this->authorize('reject', $post);

    // إرسال إشعار للمستخدم قبل الحذف
    $post->user->notify(new PostRejectedNotification($post));

    $post->delete();

    return redirect()->back()->with('success', 'تم رفض المقال وحذفه.');
}

}
