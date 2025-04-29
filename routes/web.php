<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PostReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\User\UserNotificationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PostController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// صفحات عامة
Route::get('/', function (Request $request) {
    $sort = $request->get('sort', 'latest');

    $posts = Post::where('status', 'approved')
        ->with('category')
        ->when($sort === 'popular', fn($q) => $q->withCount('likes')->orderByDesc('likes_count'))
        ->when($sort === 'latest', fn($q) => $q->latest())
        ->get();

    return view('site.home', compact('posts', 'sort'));
})->name('home');
Route::view('/about', 'site.about')->name('about');
Route::view('/terms', 'site.terms')->name('terms');

Route::get('/search', [PostController::class, 'search'])->name('posts.search');

// صفحات الأقسام
Route::get('/{categorySlug}', [PostController::class, 'indexByCategory'])
    ->where('categorySlug', 'love-table|desert-flower|health-awareness|voices-of-war|memories|weather-tips')
    ->name('posts.byCategory');

// التفاعل مع المقالات
Route::post('/posts/{post}/like', [PostController::class, 'like'])->middleware('auth')->name('posts.like');
Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->middleware('auth')->name('posts.comment');
Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');

// إدارة المقالات من قبل المستخدمين
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/my-articles', [PostController::class, 'myArticles'])->name('posts.my');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// لوحة تحكم المشرف (dashboard + مراجعة المقالات)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/review-posts', [PostReviewController::class, 'index'])->name('admin.posts.review');
    Route::post('/review-posts/{post}/approve', [PostReviewController::class, 'approve'])->name('admin.posts.approve');
    Route::delete('/review-posts/{post}/reject', [PostReviewController::class, 'reject'])->name('admin.posts.reject');
});
// تحويل Route Breeze الافتراضي إلى لوحة التحكم
Route::get('/dashboard', function () {
    if (auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('posts.my'); // صفحة مقالاتي للمستخدم العادي
    }
})->middleware('auth')->name('dashboard');

// إشعارات المستخدم
Route::middleware('auth')->prefix('notifications')->group(function () {
    Route::get('/', [UserNotificationsController::class, 'index'])->name('user.notifications');
    Route::post('/read', [UserNotificationsController::class, 'markAllAsRead'])->name('user.notifications.read');
    Route::delete('/{id}', [UserNotificationsController::class, 'destroy'])->name('user.notifications.destroy');
});

// Laravel Breeze (التسجيل وتسجيل الدخول)
require __DIR__.'/auth.php';
