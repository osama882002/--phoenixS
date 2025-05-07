<div class="bg-white p-4 rounded-xl shadow mb-6" id="post-{{ $post->id }}">
    <div class="grid grid-cols-1 gap-4">
        
        {{-- عنوان المقال
        <a href="{{ route('posts.show', $post->id) }}">
        <h2 class="text-xl font-bold text-indigo-700">{{ $post->title }}</h2>
        </a> --}}
        {{-- معلومات النشر --}}
        <div class="flex flex-col text-sm text-gray-600 space-y-1">
            <span>بواسطة: {{ $post->user->name }}</span>
            <span>القسم: {{ $post->category->name }}</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>
        
        {{-- الوسائط --}}
        <a href="{{ route('posts.show', $post->id) }}">
        @if ($post->media_path)
            <div class="mt-4">
                @if (Str::endsWith($post->media_path, ['.mp4']))
                    <video controls class="w-full rounded-lg shadow">
                        <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                    </video>
                @else
                    <img src="{{ asset('storage/' . $post->media_path) }}"
                        class="w-full max-h-64 object-contain rounded-lg shadow" alt="media">
                @endif
            </div>
        @else
            <div class="w-full h-[270px] bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                لا توجد صورة
            </div>
        @endif
        </a>
        {{-- محتوى المقال --}}
        <p class="mt-3 text-gray-800">{{ Str::limit($post->body, 200) }}</p>

        {{-- حالة المقال --}}
        @if (!empty($showStatus) && isset($post->status))
            <p class="text-sm mt-2 font-medium">
                الحالة:
                @switch($post->status)
                    @case('approved')
                        <span class="text-green-600">منشور ✅</span>
                    @break

                    @case('pending')
                        <span class="text-yellow-600">قيد المراجعة ⏳</span>
                    @break

                    @case('rejected')
                        <span class="text-red-600">مرفوض ❌</span>
                    @break

                    @default
                        <span class="text-gray-600">غير معروف</span>
                @endswitch
            </p>
        @endif

        {{-- تفاعلات المقال --}}
        @if ($post->status === 'approved')
            <div class="mt-4 flex gap-6 items-center text-sm text-gray-600">
                <div class="flex items-center gap-1 cursor-pointer hover:text-red-500"
                    onclick="toggleLike({{ $post->id }})" id="like-button-{{ $post->id }}">
                    {!! $post->likes->contains(auth()->id()) ? '💔 إلغاء الإعجاب' : '❤️ أعجبني' !!}
                    (<span id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes()->count() }}</span>)
                </div>

                <a href="javascript:void(0);" onclick="toggleComments({{ $post->id }})" class="hover:underline">
                    💬 التعليقات ({{ $post->topLevelComments->count() }})
                </a>
            </div>

            @auth
                @if (auth()->user()->unreadNotifications->where('data.post_id', $post->id)->count())
                    <div class="mt-2 text-xs text-green-600">📌 لديك تفاعل جديد على هذا المقال</div>
                @endif

                {{-- التعليقات --}}
                <div class="mt-6 bg-gray-50 p-4 rounded shadow-sm hidden" id="comments-{{ $post->id }}">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">💬 التعليقات:</h3>

                    {{-- نموذج إضافة تعليق --}}
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
            @endauth
        @endif

        {{-- إجراءات التحكم --}}
        @if (!empty($showActions))
            <div class="flex gap-3 mt-4">
                <a href="{{ route('posts.edit', $post) }}" class="text-sm text-indigo-600 hover:underline">تعديل</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">حذف</button>
                </form>
            </div>
        @endif
    </div>
</div>

<script src="{{ asset('assets/js/posts/post-interactions.js') }}"></script>