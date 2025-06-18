<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\PostReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\User\UserNotificationsController;
use App\Http\Controllers\WeatherController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PostController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Auth\SocialController;

// صفحات عامة
Route::get('/', function (Request $request) {
    $categories = Category::all();
    $sort = $request->get('sort', 'latest');

    $posts = Post::where('status', 'approved')
        ->with('category')
        ->when($sort === 'popular', fn($q) => $q->withCount('likes')->orderByDesc('likes_count'))
        ->when($sort === 'latest', fn($q) => $q->latest())
        ->take(3) // 👈 عدّل حسب ما تريد عرضه
        ->get();

    return view('site.home', compact('posts', 'sort', 'categories'));
})->name('home');

Route::view('/about', 'site.about')->name('about');
Route::view('/terms', 'site.terms')->name('terms');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::view('/contact', 'contact')->name('contact');


// صفحات الأقسام
Route::get('/{categorySlug}', [PostController::class, 'indexByCategory'])
    ->where('categorySlug', 'love-table|desert-flower|health-awareness|voices-of-war|memories')
    ->name('posts.byCategory');

// التفاعل مع المقالات
Route::post('/posts/{post}/like', [PostController::class, 'like'])->middleware('auth')->name('posts.like');
Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->middleware('auth')->name('posts.comment');
// Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply')->middleware('auth');
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

// لوحة تحكم المشرف + إشعارات
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // مراجعة المقالات
    Route::get('/review-posts', [PostReviewController::class, 'index'])->name('posts.review');
    Route::post('/review-posts/{post}/approve', [PostReviewController::class, 'approve'])->name('posts.approve');
    Route::delete('/review-posts/{post}/reject', [PostReviewController::class, 'reject'])->name('posts.reject');

    // تفاصيل المستخدمين
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users.index');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users/{user}/role', [AdminDashboardController::class, 'updateUserRole'])->name('users.updateRole');

    // تفاصيل المقالات
    Route::get('/posts', [AdminDashboardController::class, 'posts'])->name('posts.index');
    Route::delete('/posts/{post}', [AdminDashboardController::class, 'destroyPost'])->name('posts.destroy');

    // إشعارات المشرف
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::delete('/notifications/clear-read', [AdminNotificationController::class, 'clearRead'])->name('notifications.clearRead');
    Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/{post}/approve', [AdminNotificationController::class, 'approve'])->name('notifications.approve');
    Route::delete('/notifications/{post}/reject', [AdminNotificationController::class, 'reject'])->name('notifications.reject');
});

// توجيه لوحة التحكم
Route::get('/dashboard', function () {
    return auth::user()->hasAnyRole(['admin', 'super-admin'])
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home');
})->middleware('auth')->name('dashboard');



// إشعارات المستخدم
Route::middleware('auth')->prefix('notifications')->group(function () {
    Route::get('/', [UserNotificationsController::class, 'index'])->name('user.notifications');
    Route::post('/read', [UserNotificationsController::class, 'markAllAsRead'])->name('user.notifications.read');
    Route::delete('/{id}', [UserNotificationsController::class, 'destroy'])->name('user.notifications.destroy');
    Route::delete('/notifications/clear-all', [UserNotificationsController::class, 'clearAll'])->name('user.notifications.clear');
});



// الطقس
Route::get('/weather-tips', [WeatherController::class, 'showWeatherTips'])->name('weather.tips');
Route::get('/api/weather', [WeatherController::class, 'index'])->name('api.weather');



Route::get('/auth/{provider}', [SocialController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback']);



// Laravel Breeze
require __DIR__.'/auth.php';
