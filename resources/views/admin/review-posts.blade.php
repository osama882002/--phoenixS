{{-- resources/views/admin/review-posts.blade.php --}}
@extends('layouts.app')

@php
    if (auth()->check()) {
        auth()->user()->unreadNotifications->markAsRead();
    }
@endphp

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <x-admin.sidebar active="review" />

    <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        <div class="mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-indigo-700 dark:text-indigo-300">📝 مراجعة المقالات</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm">راجع ووافق أو ارفض المقالات التي أرسلها المستخدمون.</p>
        </div>

        @if ($pendingPosts->isEmpty())
            <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded text-yellow-800 dark:text-yellow-300 text-center shadow">
                لا توجد مقالات قيد المراجعة حاليًا.
            </div>
        @else
            <div class="space-y-8">
                @foreach ($pendingPosts as $post)
                    <div id="post-{{ $post->id }}"
                        class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md dark:shadow-gray-700/30 transition duration-200">
                        
                        {{-- العنوان والمعلومات --}}
                        <div class="mb-4">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                            <div class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                ✍️ <strong>{{ $post->user->name }}</strong> | 🗂️ {{ $post->category->name }}
                            </div>
                        </div>

                        {{-- الوسائط --}}
                        <div class="my-6">
                            @if ($post->media_path)
                                <div class="flex justify-center items-center cursor-pointer"
                                    onclick="openMediaModal('{{ asset('storage/' . $post->media_path) }}', '{{ Str::endsWith($post->media_path, ['.mp4']) ? 'video' : 'image' }}')">
                                    @if (Str::endsWith($post->media_path, ['.mp4']))
                                        <video controls
                                            class="w-full max-w-2xl max-h-[500px] rounded shadow-lg object-contain"
                                            loading="lazy">
                                            <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $post->media_path) }}"
                                            class="w-full max-w-2xl max-h-[500px] rounded shadow-lg object-contain"
                                            alt="صورة المقال" loading="lazy">
                                    @endif
                                </div>
                            @else
                                <div class="h-64 flex justify-center items-center bg-gray-100 dark:bg-gray-800 rounded text-gray-400 dark:text-gray-500 text-sm shadow-inner">
                                    لا توجد وسائط مرتبطة بهذا المقال
                                </div>
                            @endif
                        </div>

                        {{-- محتوى المقال --}}
                        <p class="text-gray-800 dark:text-gray-200 leading-relaxed mb-4 whitespace-pre-line">
                            {{ $post->body }}
                        </p>

                        {{-- أزرار القرار --}}
                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            @can('approve', $post)
                                <form method="POST" action="{{ route('admin.posts.approve', $post) }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded text-sm font-semibold transition">
                                        ✅ قبول المقال
                                    </button>
                                </form>
                            @endcan

                            @can('reject', $post)
                                <form method="POST" action="{{ route('admin.posts.reject', $post) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded text-sm font-semibold transition">
                                        ❌ رفض المقال
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>

{{-- Lightbox modal لعرض الوسائط --}}
@include('components.mediaModal')
@endsection
