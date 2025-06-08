{{-- resources/views/site/health-awareness.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-center bg-green-100 dark:bg-green-900 p-4 rounded-lg mb-6 shadow-md dark:shadow-green-900/30 gap-3">
            <h1 class="text-xl sm:text-2xl font-bold text-green-700 dark:text-green-300 whitespace-nowrap">
                🩺 التوعية الصحية
            </h1>
            <a href="{{ route('posts.create') }}"
               class="bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded-full text-xs sm:text-sm hover:bg-green-700 dark:hover:bg-green-800 transition w-full sm:w-auto text-center">
                ➕ إضافة مقال
            </a>
        </div>

        {{-- Description --}}
        <p class="text-gray-600 dark:text-gray-300 mb-6 sm:mb-8 text-sm sm:text-base max-w-3xl mx-auto">
            قسم يهدف إلى نشر الوعي الصحي بين الأفراد المتأثرين، من خلال نصائح طبية وغذائية وتمارين بسيطة باستخدام الموارد المتاحة.
        </p>

        {{-- Posts Section --}}
        <section class="mb-8 sm:mb-12">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
                مقالات صحية من المجتمع
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse ($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @empty
                    @include('components.no-post')
                @endforelse
            </div>
        </section>
    </div>
@endsection