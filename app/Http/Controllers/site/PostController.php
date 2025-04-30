<?php

namespace App\Http\Controllers\Site;

use App\Models\Category;
use App\Notifications\PostCommentedNotification;
use App\Notifications\PostLikedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Controller;
use App\Notifications\NewPostSubmitted;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PostController extends Controller
{
    use AuthorizesRequests;



    public function indexByCategory($slug)
    {
        $posts = Post::where('status', 'approved')
            ->whereHas('category', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })->withCount('likes')->latest()->get();

        $viewPath = "site.$slug";

        if (!View::exists($viewPath)) {
            abort(404, 'الصفحة غير موجودة.');
        }

        return view($viewPath, compact('posts'));
    }
    public function create()
    {

        // $user = auth::user();

        // if ($user && $user->hasRole('admin')) {
        //     dd('المستخدم هو أدمن ✅');
        // } else {
        //     dd('❌ ليس أدمن');
        // }
        $categories = Category::all();
        return view('site.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'idea' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        $mediaPath = $request->hasFile('media')
            ? $request->file('media')->store('uploads', 'public')
            : null;
    
        $status = auth::user()->hasRole('admin') ? 'approved' : 'pending';
    
        $post = Post::create([
            'user_id'     => Auth::id(),
            'title'       => substr($request->idea, 0, 60),
            'body'        => $request->idea,
            'media_path'  => $mediaPath,
            'category_id' => $request->category_id,
            'status'      => $status,
        ]);
    
        // إشعار المشرفين فقط إذا لم يكن أدمن
        if (!auth::user()->hasRole('admin')) {
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewPostSubmitted($post));
            }
        }
    
        return redirect()->route(
            auth::user()->hasRole('admin') ? 'admin.posts.index' : 'posts.my'
        )->with('success', auth::user()->hasRole('admin') ? 'تم نشر المقال مباشرة.' : 'تم إرسال المقال للمراجعة.');
    }
    

    public function show(Post $post)
{
    $user = auth::user();

    // السماح لصاحب المقال بمشاهدة مقاله مهما كانت الحالة
    if ($post->status !== 'approved' && $post->user_id !== $user->id) {
        abort(403, 'ليس لديك إذن لعرض هذا المقال.');
    }

    return view('site.show', compact('post'));
}

    public function myArticles(Request $request)
    {
        $query = Post::with('category')->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->get('sort') === 'popular') {
            $query->withCount('likes')->orderByDesc('likes_count');
        } else {
            $query->latest(); // default: latest
        }

        $posts = $query->get();
        $categories = Category::all();

        return view('site.my-articles', compact('posts', 'categories'));
    }


    public function search(Request $request)
    {
        $query = $request->input('q');

        $posts = Post::where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('body', 'like', "%{$query}%");
            })
            ->withCount('likes')
            ->latest()
            ->get();

        return view('site.search-results', compact('posts', 'query'));
    }
    public function like(Post $post)
    {
        $user = auth::user();

        $likedBefore = $post->likes()->where('user_id', $user->id)->exists();
        $post->likes()->toggle($user->id);

        if (!$likedBefore && $post->user_id !== $user->id) {
            $post->user->notify(new \App\Notifications\PostLikedNotification($post));
        }

        return response()->json([
            'liked' => !$likedBefore,
            'likes_count' => $post->likes()->count()
        ]);
    }



    public function comment(Request $request, Post $post)
    {
        $request->validate(['body' => 'required|string']);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);
        if ($post->user_id !== auth::id()) {
            $post->user->notify(new PostCommentedNotification($post));
        }

        return response()->json([
            'body' => $request->body,
            'user_name' => auth::user()->name,
            'comment_id' => $comment->id,
            'can_delete' => auth::user()->can('delete', $comment), // ⬅️ هذه الإضافة
        ]);
    }
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // تحقق من الصلاحية إن وُجدت سياسة
        return view('site.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post); // للتحقق من الصلاحية

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4'
        ]);

        $data = [
            'title' => $request->title,
            'body' => $request->body,
        ];

        if ($request->hasFile('media')) {
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }
            $data['media_path'] = $request->file('media')->store('uploads', 'public');
        }

        $post->update($data);

        return redirect()->route('posts.my')->with('success', 'تم تحديث المقال بنجاح.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->media_path) {
            Storage::disk('public')->delete($post->media_path);
        }

        $post->delete();
        return redirect()->route('posts.my')->with('success', 'تم حذف المقال.');
    }
}
