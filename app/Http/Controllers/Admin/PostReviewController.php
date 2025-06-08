<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostReviewedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostReviewController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        // // تعليم جميع الإشعارات كمقروءة عند زيارة الصفحة
        //   Auth::user()->unreadNotifications->markAsRead();
        $this->authorize('review', Post::class);

        $pendingPosts = Post::with(['user', 'category']) // تحميل العلاقات
            ->where('status', 'pending')
            ->get();
        return view('admin.review-posts', compact('pendingPosts'));
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', $post);

        $post->update(['status' => 'approved']);

        // إشعار للسوبر أدمن
        $superAdmins = User::role('super-admin')->get();
        foreach ($superAdmins as $superAdmin) {
            $superAdmin->notify(new PostReviewedNotification($post, auth::user(), 'approved'));
        }
        // إرسال إشعار للمستخدم
        $post->user->notify(new PostApprovedNotification($post));

        return redirect()->back()->with('success', 'تمت الموافقة على المقال.');
    }


    public function reject(Post $post)
    {
        $this->authorize('reject', $post);

        // إشعار للسوبر أدمن
        $superAdmins = User::role('super-admin')->get();
        foreach ($superAdmins as $superAdmin) {
            $superAdmin->notify(new PostReviewedNotification($post, auth::user(), 'rejected'));
        }
        // إرسال إشعار للمستخدم قبل الحذف
        $post->user->notify(new PostRejectedNotification($post));

        $post->delete();

        return redirect()->back()->with('success', 'تم رفض المقال وحذفه.');
    }
}
