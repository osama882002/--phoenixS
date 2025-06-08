{{-- resources/views/site/search-results.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    {{-- Search Header --}}
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-indigo-700 dark:text-indigo-300">
            🔍 نتائج البحث عن: "{{ $query }}"
        </h1>
        <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm sm:text-base">
            عدد النتائج: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $posts->total() }}</span>
        </p>
    </div>

    {{-- Search Results --}}
    @if ($posts->isEmpty())
        <div class="bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg text-yellow-800 dark:text-yellow-300 text-center max-w-2xl mx-auto">
            لم يتم العثور على نتائج مطابقة لبحثك. حاول استخدام كلمات بحث مختلفة.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($posts as $post)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md hover:shadow-lg transition dark:shadow-gray-900/30 flex flex-col h-full">
                    {{-- Media --}}
                    @if($post->media_path)
                        <div class="mb-3 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 h-40 sm:h-48">
                            @if(Str::endsWith($post->media_path, ['.mp4', '.mov', '.webm']))
                                <video src="{{ asset('storage/' . $post->media_path) }}" 
                                       class="w-full h-full object-cover" 
                                       muted playsinline loop>
                                </video>
                            @else
                                <img src="{{ asset('storage/' . $post->media_path) }}" 
                                     alt="صورة المقال: {{ Str::limit($post->body, 50) }}"
                                     class="w-full h-full object-cover"
                                     loading="lazy">
                            @endif
                        </div>
                    @else
                        <div class="mb-3 bg-gray-100 dark:bg-gray-700 rounded-lg h-40 sm:h-48 flex items-center justify-center">
                            <span class="text-gray-400 dark:text-gray-500">لا توجد وسائط</span>
                        </div>
                    @endif

                    {{-- Post Info --}}
                    <div class="mb-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400 flex flex-wrap gap-x-2">
                        <span class="flex items-center">
                            ✍️ <span class="font-semibold ml-1">{{ $post->user->name }}</span>
                        </span>
                        <span class="flex items-center">
                            🗂️ <span class="font-semibold ml-1">{{ $post->category->name }}</span>
                        </span>
                    </div>

                    {{-- Excerpt --}}
                    <p class="text-gray-800 dark:text-gray-200 leading-relaxed mb-3 text-sm sm:text-base flex-grow">
                        {{ Str::limit(strip_tags($post->body), 150) }}
                    </p>

                    {{-- Interaction --}}
                    <div class="flex justify-between items-center text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-auto">
                        <span class="flex items-center">
                            ❤️ <span class="ml-1">{{ $post->likes_count }} إعجاب</span>
                        </span>
                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                            👁️ <span class="ml-1">عرض</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->appends(['query' => $query])->links() }}
            </div>
        @endif
    @endif
</div>
@endsection