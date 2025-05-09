<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNotificationsController extends Controller
{
    public function index()
    {
        $user = auth::user();

        // تعليم جميع الإشعارات كمقروءة
        $user->unreadNotifications->markAsRead();

        $notifications = $user->notifications()->latest()->get();

        return view('user.notifications', compact('notifications'));
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('user.notifications')->with('success', 'تم تعليم كل الإشعارات كمقروءة.');
    }
    public function destroy($id)
    {
        // $notification = auth::user()->notifications()->findOrFail($id);
        $notification = auth::user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => '✅ تم حذف الإشعار بنجاح']);
        }
        return response()->json(['success' => false, 'message' => '❌ لم يتم العثور على الإشعار'], 404);
    }
}
