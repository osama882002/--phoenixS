<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('review', Post::class);
        abort_unless(Auth::user()?->hasRole('admin'), 403);
        abort_unless(Auth::user()?->can('review posts'), 403);

        $pendingPosts = Post::where('status', 'pending')->count();
        $usersCount = User::count();
        $postsCount = Post::count();

        return view('admin.dashboard', compact('pendingPosts', 'usersCount', 'postsCount'));
    }
}
