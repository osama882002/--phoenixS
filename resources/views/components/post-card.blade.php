{{-- resources/views/components/post-card.blade.php --}}
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
        <div class="media-container h-48 bg-gray-100"> <!-- ارتفاع ثابت -->
            <a href="{{ route('posts.show', $post->id) }}">
                @if ($post->media_path)
                    @if (Str::endsWith($post->media_path, ['.mp4']))
                        <video class="object-cover h-full w-full">...</video>
                    @else
                        <img src="{{ asset('storage/' . $post->media_path) }}" class="object-cover h-full w-full"
                            alt="صورة المقال">
                    @endif
                @else
                    <div class="bg-gray-100 h-full flex items-center justify-center">
                        لا توجد صورة
                    </div>
                @endif
            </a>
        </div>
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
                    (<span
                        id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes()->count() }}</span>)
                </div>

                <a href="{{ route('posts.show', $post->id) }}" onclick="toggleComments({{ $post->id }})"
                    class="hover:underline">
                    💬 التعليقات ({{ $post->topLevelComments->count() }})
                </a>
            </div>
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
