<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\RoleChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Notifications\RoleUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class AdminDashboardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('review', Post::class);
        abort_unless(Auth::user()?->hasRole(['admin', 'super-admin']), 403);
        abort_unless(Auth::user()?->can('review posts'), 403);
        $users = User::latest()->get(); // كل المستخدمين   
        $pendingPosts = Post::where('status', 'pending')->count();
        $usersCount = User::count();
        $postsCount = Post::count();

        $postsByStatus = Post::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $weeklyPosts = Post::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topPost = Post::withCount(['likes', 'comments'])
            ->orderByDesc(DB::raw('likes_count + comments_count'))
            ->first();

        return view('admin.dashboard', compact('pendingPosts', 'usersCount', 'postsCount', 'users', 'postsByStatus', 'weeklyPosts', 'topPost'));
    }
    public function users()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // جلب جميع الأدوار من قاعدة البيانات
        return view('admin.users', compact('users', 'roles'));
    }

    public function destroyUser(User $user)
    {
        if (!auth::user()->hasRole('super-admin')) {
            return response()->json(['success' => false, 'message' => '❌ فقط السوبر أدمن يمكنه حذف المستخدمين.'], 403);
        }

        if ($user->hasRole('super-admin')) {
            return response()->json(['success' => false, 'message' => '❌ لا يمكنك حذف سوبر أدمن.'], 403);
        }

        $user->delete();
        return response()->json(['success' => true, 'message' => '✅ تم حذف المستخدم بنجاح']);
    }


    public function updateUserRole(Request $request, User $user)
    {

        if (!auth::user()->hasRole('super-admin')) {
            abort(403, 'غير مصرح لك بتغيير الدور.');
        }


        // حماية من ترقية مستخدم إلى super-admin
        if ($request->role === 'super-admin') {
            return response()->json(['success' => false, 'message' => '❌ لا يمكن تعيين دور "سوبر أدمن".'], 403);
        }

        // منع تعديل دور السوبر أدمن نفسه
        if ($user->hasRole('super-admin')) {
            return response()->json(['success' => false, 'message' => '❌ لا يمكن تعديل دور السوبر أدمن.'], 403);
        }


        $request->validate(['role' => 'required|string']);
        $user->syncRoles([$request->role]);

        // إرسال إشعار للمستخدم
        $user->notify(new RoleChangedNotification($request->role));
        // إشعار للسوبر أدمن نفسه
        foreach (User::role('super-admin')->get() as $superAdmin) {
            $superAdmin->notify(new RoleUpdatedNotification($user, $request->role));
        }
        return response()->json(['success' => true, 'message' => '✅ تم تحديث دور المستخدم']);
    }



    public function posts(Request $request)
    {
        $query = Post::with('user', 'category');

        // البحث في اسم الكاتب أو اسم القسم
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhereHas('category', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        // فلترة حسب الحالة
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $posts = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'tbody' => view('admin.posts-table', compact('posts'))->render(),
                'pagination' => (string)$posts->links()
            ]);
        }

        return view('admin.posts', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
        $post->delete();

        return response()->json(['success' => true, 'message' => '✅ تم حذف المقال بنجاح']);
    }
}
