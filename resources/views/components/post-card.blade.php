{{-- resources/views/components/post-card.blade.php --}}
{{-- resources/views/components/post-card.blade.php --}}
<div class="block bg-white dark:bg-gray-800 rounded-xl overflow-hidden transform transition duration-300 hover:scale-[1.02] hover:-translate-y-1 shadow-md dark:shadow-gray-700 hover:shadow-lg dark:hover:shadow-xl h-full flex flex-col"
    id="post-{{ $post->id }}">

    {{-- الوسائط - نسبة 16:9 --}}
    <div class="relative aspect-video bg-gray-100 dark:bg-gray-700 overflow-hidden">
        <a href="{{ route('posts.show', $post->id) }}" class="block h-full w-full">
            @if ($post->media_path)
                @php
                    $isVideo = Str::endsWith($post->media_path, ['.mp4', '.mov', '.webm']);
                @endphp
                @if ($isVideo)
                    <video muted autoplay loop playsinline preload="metadata"
                        class="absolute inset-0 w-full h-full object-contain"
                        loading="lazy">
                        <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <img src="{{ asset('storage/' . $post->media_path) }}"
                        class="absolute inset-0 w-full h-full object-contain"
                        alt="صورة المقال: {{ Str::limit($post->body, 50) }}"
                        loading="lazy">
                @endif
            @else
                <div class="h-full w-full flex items-center justify-center text-gray-500 dark:text-gray-400">
                    لا توجد وسائط
                </div>
            @endif
        </a>
    </div>

    {{-- محتوى المقال --}}
    <div class="p-4 flex-grow flex flex-col">
        {{-- معلومات المقال --}}
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 dark:text-indigo-300 text-sm font-medium">
                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                </div>
                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $post->user->name }}</span>
            </div>
            <span class="text-xs px-2 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300">
                {{ $post->category->name }}
            </span>
        </div>

        {{-- نص المقال --}}
        <p class="text-gray-800 dark:text-gray-200 text-sm line-clamp-3 mb-3 flex-grow">
            {{ Str::limit($post->body, 40) }}
        </p>

        {{-- معلومات إضافية --}}
        <div class="flex items-center justify-between mt-auto">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                {{ $post->created_at->diffForHumans() }}
            </span>

            {{-- حالة المقال --}}
            @if (!empty($showStatus) && isset($post->status))
                <span class="text-xs font-medium px-2 py-1 rounded-full
                    @switch($post->status)
                        @case('approved') bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 @break
                        @case('pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300 @break
                        @case('rejected') bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 @break
                        @default bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300
                    @endswitch">
                    @switch($post->status)
                        @case('approved') منشور @break
                        @case('pending') قيد المراجعة @break
                        @case('rejected') مرفوض @break
                        @default غير معروف
                    @endswitch
                </span>
            @endif
        </div>

        {{-- تفاعلات المقال --}}
        @if ($post->status === 'approved')
            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center text-sm">
                    <button onclick="toggleLike({{ $post->id }})" 
                            class="flex items-center gap-1 hover:text-red-500 dark:hover:text-red-400 transition-colors"
                            id="like-button-{{ $post->id }}">
                        {!! $post->likes->contains(auth()->id()) ? '💔' : '❤️' !!}
                        <span id="like-count-{{ $post->id }}" class="ml-1">
                            {{ $post->likes_count ?? $post->likes()->count() }}
                        </span>
                    </button>

                    <a href="{{ route('posts.show', $post->id) }}#comments"
                        class="flex items-center gap-1 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors">
                        💬 <span class="ml-1">{{ $post->topLevelComments->count() }}</span>
                    </a>

                </div>
            </div>
        @endif

        {{-- إجراءات التحكم --}}
        @if (!empty($showActions))
            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('posts.edit', $post) }}"
                    class="p-2 rounded-full hover:bg-green-100 dark:hover:bg-green-900 text-green-600 dark:text-green-400 transition-colors"
                    title="تعديل">
                    ✏️
                </a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="p-2 rounded-full hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400 transition-colors"
                        title="حذف"
                        onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذا المقال؟')">
                        🗑️
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>

<script src="{{ asset('assets/js/posts/post-interactions.js') }}"></script>
