{{-- resources/views/admin/review-posts.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="mb-10">
        <h1 class="text-2xl font-bold text-indigo-700">مراجعة المقالات المرسلة</h1>
        <p class="text-gray-600 mt-1">راجع ووافق أو ارفض المقالات التي أرسلها المستخدمون.</p>
    </div>

    @if (auth()->user()->unreadNotifications->count())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
            <strong>إشعارات جديدة:</strong>
            <ul class="mt-2 list-disc pr-6">
                @foreach (auth()->user()->unreadNotifications as $notification)
                    <li>
                        <span class="text-sm">
                            مقالة جديدة: <strong>{{ $notification->data['title'] ?? 'عنوان غير متوفر' }}</strong> بواسطة
                            {{ $notification->data['author'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($pendingPosts->isEmpty())
        <div class="bg-yellow-100 p-4 rounded text-yellow-800">لا توجد مقالات قيد المراجعة حاليًا.</div>
    @else
        <div class="space-y-6">
            @foreach ($pendingPosts as $post)
            <div id="post-{{ $post->id }}" class="bg-white p-4 rounded shadow mt-4">
                {{-- تفاصيل المقال... --}}
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-600 mb-2">بواسطة: {{ $post->user->name }} | القسم:
                        {{ $post->category->name }}</p>
                    <p class="text-gray-700 mb-2">{{ $post->body }}</p>
                    @if ($post->media_path)
                        <div class="mb-2">
                            @if (Str::endsWith($post->media_path, ['.mp4']))
                                <video controls class="w-full rounded">
                                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $post->media_path) }}" alt="media"
                                    class="rounded w-200 h-200">
                            @endif
                        </div>
                    @endif
                    <div class="flex gap-4 mt-3">
                        @can('approve', $post)
                            <form method="POST" action="{{ route('admin.posts.approve', $post) }}">
                                @csrf
                                <button type="submit"
                                    class="text-xs bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">✅
                                    قبول</button>
                            </form>
                        @endcan

                        @can('reject', $post)
                            <form method="POST" action="{{ route('admin.posts.reject', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-xs bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">❌
                                    رفض</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
