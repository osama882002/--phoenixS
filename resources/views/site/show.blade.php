{{-- resources/views/site/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow" id="post-{{ $post->id }}">
        <!-- ... (بقية المحتوى كما هو حتى قسم التفاعل) ... -->
        <div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow">

            {{-- عنوان المقال
            <h1 class="text-3xl font-bold text-indigo-700 mb-4">{{ $post->title }}</h1>  --}}

            {{-- معلومات إضافية --}}
            <p class="text-sm text-gray-600 mb-2">
                بواسطة: {{ $post->user->name }} |
                القسم: {{ $post->category->name }} |
                منذ: {{ $post->created_at->diffForHumans() }}
            </p>

            {{-- عرض صورة أو فيديو --}}
            @if ($post->media_path)
                <div class="my-6 flex justify-center items-center">
                    @if (Str::endsWith($post->media_path, ['.mp4']))
                        <video controls class="w-full rounded-lg shadow">
                            <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $post->media_path) }}"
                            class="rounded-lg shadow w-[400px] h-[400px] object-cover " />
                    @endif
                </div>
            @endif

            {{-- نص المقال الكامل --}}
            <div class="text-gray-800 leading-relaxed mb-8 whitespace-pre-line">
                {{ $post->body }}
            </div>

            {{-- التفاعل (إعجاب، عدد التعليقات) --}}
            <div class="flex gap-6 items-center text-sm text-gray-600 mb-8">
                <div class="flex items-center gap-1 cursor-pointer hover:text-red-500"
                    onclick="toggleLike({{ $post->id }})" id="like-button-{{ $post->id }}">
                    {!! $post->likes->contains(auth()->id()) ? '💔 إلغاء الإعجاب' : '❤️ أعجبني' !!}
                    (<span id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes()->count() }}</span>)
                </div>

                <a href="javascript:void(0);" onclick="toggleComments({{ $post->id }})" class="hover:underline">
                    💬 التعليقات ({{ $post->topLevelComments->count() }})
                </a>
                <button onclick="sharePost('{{ $post->title }}', '{{ route('posts.show', $post) }}')"
                    class="flex items-center gap-1 text-lg hover:text-blue-500">
                    ↗️ <span class="text-sm">مشاركة</span>
                </button>
            </div>

            {{-- @auth
                @if (auth()->user()->unreadNotifications->where('data.post_id', $post->id)->count())
                    <div class="mt-2 text-xs text-green-600">📌 لديك تفاعل جديد على هذا المقال</div>
                @endif
            @endauth --}}

            {{-- التعليقات --}}
            <div class="mt-6 bg-gray-50 p-4 rounded shadow-sm hidden" id="comments-{{ $post->id }}">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">💬 التعليقات:</h3>

                {{-- نموذج إضافة تعليق --}}
                @auth
                    <form onsubmit="submitComment(event, {{ $post->id }})" class="mb-4"
                        id="comment-form-{{ $post->id }}">
                        @csrf
                        <textarea id="comment-body-{{ $post->id }}" rows="2" class="w-full border rounded p-2 text-sm"
                            placeholder="اكتب تعليقك..." required></textarea>
                        <button type="submit"
                            class="mt-2 bg-indigo-600 text-white px-4 py-1 rounded text-sm hover:bg-indigo-700">
                            إرسال التعليق
                        </button>
                    </form>
                @endauth

                <div id="comments-container-{{ $post->id }}" class="space-y-4">
                    @foreach ($post->topLevelComments as $index => $comment)
                        <div class="comment-item-{{ $post->id }} {{ $index > 2 ? 'hidden' : '' }}"
                            data-comment-id="{{ $comment->id }}">
                            <div class="mb-4 border-b pb-3 border-gray-200">
                                <p class="text-sm text-gray-800">{{ $comment->body }}</p>
                                <span class="text-xs text-gray-500">بواسطة {{ $comment->user->name }} -
                                    {{ $comment->created_at->diffForHumans() }}</span>
                                @can('delete', $comment)
                                    <button onclick="deleteComment('{{ $comment->id }}', '{{ $post->id }}')"
                                        class="text-xs text-red-600 hover:underline ml-2">🗑️ حذف</button>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($post->topLevelComments->count() > 3)
                    <div class="mt-2 text-center">
                        <button id="load-more-btn-{{ $post->id }}" onclick="toggleCommentsExpand({{ $post->id }})"
                            class="text-indigo-600 hover:underline text-sm">
                            🔽 عرض المزيد
                        </button>
                        <button id="collapse-comments-btn-{{ $post->id }}"
                            onclick="collapseComments({{ $post->id }})"
                            class="text-indigo-600 hover:underline text-sm hidden">
                            🔼 إخفاء التعليقات
                        </button>
                    </div>
                @endif
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-indigo-600 hover:underline text-sm">
                    ⬅️ العودة للصفحة الرئيسية
                </a>
            </div>
        </div>

    </div>
    {{-- مقالات مشابهة --}}
    @if ($relatedPosts->count())
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">مقالات مشابهة في قسم {{ $post->category->name }}
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $related)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('posts.show', $related) }}">
                            @if ($related->media_path)
                                <div class="h-48 overflow-hidden">
                                    @if (Str::endsWith($related->media_path, ['.mp4']))
                                        <video class="w-full h-full object-cover">
                                            <source src="{{ asset('storage/' . $related->media_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $related->media_path) }}"
                                            class="w-full h-full object-cover" loading="lazy" alt="{{ $related->title }}">
                                    @endif
                                </div>
                            @else
                                <div class="h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                    لا توجد صورة
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 line-clamp-2">{{ $related->title }}</h3>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $related->created_at->diffForHumans() }}</span>
                                    <span>❤️ {{ $related->likes_count }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <script src="{{ asset('assets/js/posts/post-interactions.js') }}"></script>
@endsection
