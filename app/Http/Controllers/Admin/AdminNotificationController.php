<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Post;
use App\Notifications\PostApprovedNotification;
use App\Notifications\PostRejectedNotification;

class AdminNotificationController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('admin.notifications')->with('success', 'تم تعليم الكل كمقروء.');
    }

    public function clearRead()
    {
        Auth::user()->readNotifications()->delete();
        return redirect()->route('admin.notifications')->with('success', 'تم حذف الإشعارات المقروءة.');
    }

    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => '✅ تم حذف الإشعار بنجاح']);
    }
    return response()->json(['success' => false, 'message' => '❌ فشل حذف الإشعار أو أنه غير موجود'], 404);
    }

    public function approve(Post $post)
    {
        $this->authorize('approve', $post);
        abort_unless(auth::user()->hasRole(['admin', 'super-admin']), 403);

        $post->update(['status' => 'approved']);
        $post->user->notify(new PostApprovedNotification($post));
        return redirect()->back()->with('success', 'تمت الموافقة على المقال.');
    }

    public function reject(Post $post)
    {
        $this->authorize('reject', $post);
        abort_unless(auth::user()->hasRole(['admin', 'super-admin']), 403);
        $post->user->notify(new PostRejectedNotification($post));
        $post->delete();
        return redirect()->back()->with('success', 'تم رفض المقال وحذفه.');
    }
}
