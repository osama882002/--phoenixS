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

        //     if ($request->hasFile('media')) {
        //     $file = $request->file('media');
        //     dd([
        //         'extension' => $file->getClientOriginalExtension(),
        //         'mimeType' => $file->getMimeType(),
        //     ]);
        // }
        // الحصول على بيانات الملف (إن وُجد)
        $file = $request->file('media');

        // تحديد الرسائل الديناميكية
        $messages = [];

        if ($request->hasFile('media')) {
            $mimeType = $file->getMimeType(); // مثل image/gif
            $extension = $file->getClientOriginalExtension(); // مثل gif

            $messages['media.mimeType'] = "❌ الصيغة غير مدعومة. لقد رفعت ملف بصيغة .$mimeType ، بينما يُسمح بـ JPG, PNG, JPEG أو MP4 فقط.";
        }
        $request->validate([
            'idea' => 'required|string',
            'media' => 'nullable|file|mimetypes:video/mp4,application/octet-stream,image/jpeg,image/png,image/jpg,image/gif,image/webp|max:51200',
            'category_id' => 'required|exists:categories,id',
        ], [

            'idea.required' => '❌ الرجاء كتابة فكرة المقال.',
            'category_id.required' => '❌ الرجاء اختيار القسم.',
            'media.file' => '❌ يجب أن يكون الملف صورة أو فيديو.',
            // 'media.mimes' => '❌ الصيغة غير مدعومة. يُسمح بـ JPG, PNG, JPEG أو MP4 فقط.',
            'media.mimeType' => $messages,
            'media.max' => '❌ الحد الأقصى للحجم هو 50 ميجابايت.',
        ]);

        $mediaPath = null;

        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $originalExtension = strtolower($media->getClientOriginalExtension()); // يستخرج mp4 أو jpeg إلخ
            $filename = 'user_' . auth::id() . '_' . now()->format('YmdHis') . '.' . $originalExtension;

            $mediaPath = $media->storeAs('media', $filename, 'public'); // يحفظ بالاسم والامتداد الصحيح

            // التحقق من أن الملف تم رفعه بنجاح
            if (!$mediaPath) {
                return back()->with('error', 'فشل في رفع الملف. يرجى المحاولة بملف آخر.');
            }
        }




        $status = auth::user()->hasAnyRole(['admin', 'super-admin']) ? 'approved' : 'pending';

        $post = Post::create([
            'user_id' => auth::id(),
            'body' => $request->idea,
            'media_path' => $mediaPath,
            'category_id' => $request->category_id,
            'status' => $status,
        ]);

        if (!auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            $admins = User::role(['admin', 'super-admin'])->get();
            foreach ($admins as $admin) {
                $post->load('user');
                $admin->notify(new NewPostSubmitted($post));
            }
        }


        // return redirect()->route(
        //     auth::user()->hasRole('admin') ? 'admin.posts.index' : 'posts.my'
        // )->with('success', auth::user()->hasRole('admin') ? 'تم نشر المقال مباشرة.' : 'تم إرسال المقال للمراجعة.');

        return redirect()->route('posts.my')->with(
            'success',
            auth::user()->hasAnyRole(['admin', 'super-admin'])
                ? 'تم نشر المقال مباشرة.'
                : 'تم إرسال المقال للمراجعة.'
        );
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'body' => 'required|string',
            'media' => 'nullable|file|mimetypes:video/mp4,application/octet-stream,image/jpeg,image/png,image/jpg,image/gif,image/webp|max:51200',
            'category_id' => 'required|exists:categories,id',
        ], [
            'idea.required' => '❌ الرجاء كتابة فكرة المقال.',
            'category_id.required' => '❌ الرجاء اختيار القسم.',
            'media.file' => '❌ يجب أن يكون الملف صورة أو فيديو.',
            'media.mimeType' => '❌ الصيغة غير مدعومة. يُسمح بـ JPG, PNG, JPEG أو MP4 فقط.',
            'media.max' => '❌ الحد الأقصى للحجم هو 50 ميجابايت.',
        ]);

        $data = [
            'body' => $request->body,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('media')) {
            // حذف الملف القديم إن وجد
            if ($post->media_path) {
                Storage::disk('public')->delete($post->media_path);
            }

            $media = $request->file('media');
            $originalExtension = strtolower($media->getClientOriginalExtension()); // يستخرج mp4 أو jpeg إلخ
            $filename = 'user_' . auth::id() . '_' . now()->format('YmdHis') . '.' . $originalExtension;

            $data['media_path'] = $media->storeAs('uploads', $filename, 'public');

            if (!$data['media_path']) {
                return back()->with('error', 'فشل في تحديث الملف المرفق.');
            }
        }

        $post->update($data);

        return redirect()->route('posts.my')->with('success', 'تم تحديث المقال بنجاح.');
    }
    public function show(Post $post)
    {
        $user = auth::user();

        // السماح لصاحب المقال بمشاهدة مقاله مهما كانت الحالة
        if ($post->status !== 'approved' && $post->user_id !== $user->id) {
            abort(403, 'ليس لديك إذن لعرض هذا المقال.');
        }

        // استرجاع 3 مقالات مشابهة (نفس القسم، غير المقال الحالي)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->withCount('likes')
            ->orderByDesc('likes_count') // الأكثر إعجابًا أولاً
            ->orderByDesc('created_at')  // ثم الأحدث
            ->limit(3)
            ->get();

        return view('site.show', compact('post', 'relatedPosts'));
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

        $posts = $query->paginate(6);
        $categories = Category::all();

        return view('site.my-articles', compact('posts', 'categories'));
    }


    public function search(Request $request)
    {
        $query = $request->input('q');
        // ✅ إذا لم يُدخل المستخدم كلمة، أعده مع رسالة خطأ
        if (empty($query) || mb_strlen($query) < 3) {
            return redirect()->back()->with('error', '⚠️ يرجى إدخال كلمة مكونة من 3 أحرف على الأقل.');
        }
        $posts = Post::where('status', 'approved')
            ->where('body', 'like', '%' . $query . '%') // بحث جزئي داخل body
            ->with(['user', 'category']) // تحميل العلاقات
            ->withCount('likes') // إحضار عدد الإعجابات
            ->orderByDesc('likes_count') // ترتيب حسب الأكثر إعجابًا
            ->paginate(5);

        return view('site.search-results', compact('posts', 'query'));
    }


    public function like(Post $post)
    {
        $user = auth::user();

        $likedBefore = $post->likes()->where('user_id', $user->id)->exists();
        $post->likes()->toggle($user->id);

        if (!$likedBefore && $post->user_id !== $user->id) {
            $post->user->notify(new PostLikedNotification($post));
        }

        return response()->json([
            'liked' => !$likedBefore,
            'likes_count' => $post->likes()->count(),
            'message' => !$likedBefore ? 'تم الإعجاب بالمقال' : 'تم إلغاء الإعجاب'

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
            'success' => true,
            'message' => '✅ تم إضافة التعليق بنجاح',
            'body' => $request->body,
            'user_name' => auth::user()->name,
            'comment_id' => $comment->id,
            'can_delete' => auth::user()->can('delete', $comment), // ⬅️ هذه الإضافة
        ]);
    }
    public function edit(Post $post)
    {
        $this->authorize('update', $post); // تحقق من الصلاحية إن وُجدت سياسة
        $categories = Category::all(); // ⬅️ أضف هذا السطر
        return view('site.edit', compact('post', 'categories')); // ⬅️ أضف categories
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
