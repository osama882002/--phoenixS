{{-- resources/views/site/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Main Post Content --}}
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md dark:shadow-gray-900/20 p-6 mb-8" id="post-{{ $post->id }}">
        {{-- Post Meta --}}
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            بواسطة: {{ $post->user->name }} |
            القسم: {{ $post->category->name }} |
            منذ: {{ $post->created_at->diffForHumans() }}
        </p>

        {{-- Media Content --}}
        @if ($post->media_path)
            <div class="my-6 flex justify-center items-center"
                onclick="openMediaModal('{{ asset('storage/' . $post->media_path) }}', '{{ Str::endsWith($post->media_path, ['.mp4', '.mov', '.webm']) ? 'video' : 'image' }}')">
                @if (Str::endsWith($post->media_path, ['.mp4', '.mov', '.webm']))
                    <video controls class="w-full max-w-2xl max-h-[500px] aspect-video object-contain rounded shadow-lg"
                        loading="lazy">
                        <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $post->media_path) }}"
                        class="w-full max-w-2xl max-h-[500px] object-contain rounded shadow-lg" alt="صورة المقال"
                        loading="lazy">
                @endif
            </div>
        @else
            <div class="my-6 flex justify-center items-center h-64 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg shadow dark:shadow-md">
                لا توجد وسائط مرتبطة بهذا المقال
            </div>
        @endif

        {{-- Post Body --}}
        <div class="text-gray-800 dark:text-gray-200 leading-relaxed mb-8 whitespace-pre-line">
            {{ $post->body }}
        </div>

        {{-- Interactions --}}
        <div class="flex gap-6 items-center text-sm text-gray-600 dark:text-gray-300 mb-8">
            <div class="flex items-center gap-1 cursor-pointer hover:text-red-500 dark:hover:text-red-400"
                onclick="toggleLike({{ $post->id }})" id="like-button-{{ $post->id }}">
                {!! $post->likes->contains(auth()->id()) ? '💔 إلغاء الإعجاب' : '❤️ أعجبني' !!}
                (<span id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes()->count() }}</span>)
            </div>

            <a href="javascript:void(0);" onclick="toggleComments({{ $post->id }})"
                class="hover:underline text-gray-700 dark:text-gray-300">
                💬 التعليقات ({{ $post->topLevelComments->count() }})
            </a>

            <button onclick="sharePost('{{ $post->title }}', '{{ route('posts.show', $post) }}')"
                class="flex items-center gap-1 text-lg hover:text-blue-500 dark:hover:text-blue-400">
                ↗️ <span class="text-sm">مشاركة</span>
            </button>
        </div>

        {{-- Comments Section --}}
        <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded shadow-sm hidden" id="comments-{{ $post->id }}">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">💬 التعليقات:</h3>

            {{-- Comment Form --}}
            @auth
                <form onsubmit="submitComment(event, {{ $post->id }})" class="mb-4"
                    id="comment-form-{{ $post->id }}">
                    @csrf
                    <textarea id="comment-body-{{ $post->id }}" rows="2"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 text-sm bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                        placeholder="اكتب تعليقك..." required></textarea>
                    <button type="submit"
                        class="mt-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white px-4 py-1 rounded text-sm transition duration-200">
                        إرسال التعليق
                    </button>
                </form>
            @endauth

            <div id="comments-container-{{ $post->id }}" class="space-y-4">
                @foreach ($post->topLevelComments as $index => $comment)
                    <div class="comment-item-{{ $post->id }} {{ $index > 2 ? 'hidden' : '' }}"
                        data-comment-id="{{ $comment->id }}">
                        <div class="mb-4 border-b pb-3 border-gray-200 dark:border-gray-600">
                            <p class="text-sm text-gray-800 dark:text-gray-200">{{ $comment->body }}</p>
                            <span class="text-xs text-gray-500 dark:text-gray-400">بواسطة {{ $comment->user->name }} -
                                {{ $comment->created_at->diffForHumans() }}</span>
                            @can('delete', $comment)
                                <button onclick="deleteComment(event, '{{ $comment->id }}', '{{ $post->id }}')"
                                    class="text-xs text-red-600 dark:text-red-400 hover:underline ml-2">🗑️ حذف</button>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($post->topLevelComments->count() > 3)
                <div class="mt-2 text-center">
                    <button id="load-more-btn-{{ $post->id }}" onclick="toggleCommentsExpand({{ $post->id }})"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                        🔽 عرض المزيد
                    </button>
                    <button id="collapse-comments-btn-{{ $post->id }}" onclick="collapseComments({{ $post->id }})"
                        class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm hidden">
                        🔼 إخفاء التعليقات
                    </button>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline text-sm">
                ⬅️ العودة للصفحة الرئيسية
            </a>
        </div>
    </div>

{{-- قسم المقالات المتشابهة --}}
@if ($relatedPosts->count())
    <div class="max-w-5xl mx-auto mt-12">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-6 border-b pb-2 border-gray-200 dark:border-gray-600">
            مقالات مشابهة في قسم {{ $post->category->name }}
        </h2>

        {{-- الشبكة المتجاوبة --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($relatedPosts as $related)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full">
                    <a href="{{ route('posts.show', $related) }}" class="block flex-grow">
                        {{-- وسائط المقال - عرض كامل داخل الإطار --}}
                        <div class="relative h-48 sm:h-56 bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                            @if ($related->media_path)
                                @if (Str::endsWith($related->media_path, ['.mp4', '.mov', '.webm']))
                                    <video muted autoplay loop class="absolute inset-0 w-full h-full object-contain" loading="lazy">
                                        <source src="{{ asset('storage/' . $related->media_path) }}" type="video/mp4">
                                    </video>
                                @else
                                    <img src="{{ asset('storage/' . $related->media_path) }}"
                                         class="absolute inset-0 w-full h-full object-contain p-2"
                                         loading="lazy"
                                         alt="{{ $related->title }}">
                                @endif
                            @else
                                <span class="text-gray-400 dark:text-gray-500">لا توجد وسائط</span>
                            @endif
                        </div>

                        {{-- محتوى المقال --}}
                        <div class="p-4 flex-grow">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2 line-clamp-2">
                                {{ $related->title }}
                            </h3>
                            <div class="flex items-center justify-between text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $related->created_at->diffForHumans() }}</span>
                                <span class="flex items-center gap-1">
                                    ❤️ {{ $related->likes_count }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
    {{-- Media Modal --}}
    @include('components.mediaModal')
</div>

<script src="{{ asset('assets/js/posts/post-interactions.js') }}"></script>
@endsection