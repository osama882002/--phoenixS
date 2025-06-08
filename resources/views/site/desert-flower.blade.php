{{-- resources/views/site/desert-flower.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-center bg-yellow-100 dark:bg-yellow-900 p-4 rounded-lg mb-6 shadow-md dark:shadow-yellow-900/30 gap-4">
            <h1 class="text-xl sm:text-2xl font-bold text-yellow-700 dark:text-yellow-300 whitespace-nowrap">
                🌵 زهرة الصحراء
            </h1>
            <a href="{{ route('posts.create') }}"
               class="bg-yellow-600 dark:bg-yellow-700 text-white px-4 py-2 rounded-full text-xs sm:text-sm hover:bg-yellow-700 dark:hover:bg-yellow-800 transition w-full sm:w-auto text-center">
                ➕ إضافة مقال
            </a>
        </div>

        {{-- Description --}}
        <p class="text-gray-600 dark:text-gray-300 mb-6 sm:mb-8 text-sm sm:text-base max-w-3xl mx-auto">
            مساحة تُسلط الضوء على صمود وإبداع الأفراد الذين يعيشون في ظروف صعبة، وتُصوّرهم كزهور تنمو في صحراء الحياة القاسية.
        </p>

        {{-- Posts Section --}}
        <section class="mb-8 sm:mb-12">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
                قصص ملهمة من المجتمع
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