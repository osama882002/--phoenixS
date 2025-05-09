{{-- resources/views/components/post-card.blade.php --}}
<div class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl" id="post-{{ $post->id }}">
    
    <div class="grid grid-cols-1 gap-4">

        {{-- عنوان المقال
        <a href="{{ route('posts.show', $post->id) }}">
        <h2 class="text-xl font-bold text-indigo-700">{{ $post->title }}</h2>
        </a> --}}
        {{-- معلومات النشر --}}
        {{-- <div class="flex flex-col text-sm text-gray-600 space-y-1">
            <span>بواسطة: {{ $post->user->name }}</span>
            <span>القسم: {{ $post->category->name }}</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div> --}}

{{-- الوسائط --}}
<div class="aspect-video bg-gray-100"> <!-- نسبة 16:9 -->
    <a href="{{ route('posts.show', $post->id) }}">
        @if ($post->media_path)
            @php
                $isVideo = Str::endsWith($post->media_path, ['.mp4']);
            @endphp
            @if ($isVideo)
                <video class="object-cover w-full h-full" muted loop>
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" class="object-cover w-full h-full"
                    alt="صورة المقال" loading="lazy">
            @endif
        @else
            <div class="h-full w-full flex items-center justify-center text-gray-500 bg-gray-100">
                لا توجد صورة
            </div>
        @endif
    </a>
</div>

        {{-- محتوى المقال --}}
    <div class="p-4 flex-grow">        
        <div class="text-sm text-gray-600 space-y-1">
            <p class="font-medium">بواسطة: {{ $post->user->name }}</p>
            <p class="text-indigo-700 font-semibold"># {{ $post->category->name }}</p>
        </div>
        {{-- نبذة من المقال --}}
        <p class="text-sm text-gray-600 line-clamp-3">
            {{ $post->body }}
        </p>

        {{-- وقت النشر --}}
        <p class="text-xs text-gray-500 mt-2">{{ $post->created_at->diffForHumans() }}</p>

    
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
        <div class="px-4 pb-4 mt-3"> <!-- mt-auto للالتصاق بالأسفل -->
            <div class="flex justify-between text-sm">
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
        </div>
        @endif

        {{-- إجراءات التحكم --}}
        @if (!empty($showActions))
            <div class="flex gap-3 mt-4">
                <a href="{{ route('posts.edit', $post) }}" 
                class="bg-green-500 hover:bg-green-700 text-white font-bold p-2 rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center w-10 h-10">
                ✏️
                </a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold p-2 rounded-full shadow-md transition duration-300 ease-in-out transform hover:scale-105 flex items-center justify-center w-10 h-10">
                        🗑️</button>
                </form>
            </div>
        @endif
    </div>
</div>
</div>

<script src="{{ asset('assets/js/posts/post-interactions.js') }}"></script>