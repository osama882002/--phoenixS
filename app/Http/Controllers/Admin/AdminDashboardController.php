<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('review', Post::class);
        abort_unless(Auth::user()?->hasRole('admin'), 403);
        abort_unless(Auth::user()?->can('review posts'), 403);
        $users = User::latest()->get(); // كل المستخدمين   
        $pendingPosts = Post::where('status', 'pending')->count();
        $usersCount = User::count();
        $postsCount = Post::count();

        return view('admin.dashboard', compact('pendingPosts', 'usersCount', 'postsCount', 'users'));
    }
    public function users()
    {
        $users = \App\Models\User::with('roles')->get();
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->hasRole('admin')) {
            return response()->json(['error' => 'لا يمكنك حذف مشرف.'], 403);
        }

        $user->delete();
        return response()->json(['success' => true]);
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|string']);
        $user->syncRoles([$request->role]);
        return response()->json(['success' => true]);
    }

    public function posts()
    {
        $posts = Post::with('user', 'category')->latest()->get();
        return view('admin.posts', compact('posts'));
    }

    public function destroyPost(Post $post)
    {
        $post->delete();

        return response()->json(['success' => true]);
    }
}
