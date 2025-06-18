{{-- resources/views/site/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div
            class="flex flex-col md:flex-row justify-between items-center bg-indigo-100 dark:bg-indigo-900 p-4 rounded-lg mb-6 shadow-md dark:shadow-gray-700">
            <h1 class="text-xl md:text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-2 md:mb-0">🏠 الصفحة الرئيسية
            </h1>
            <a href="{{ route('posts.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full text-sm transition duration-300 whitespace-nowrap">
                ➕ إضافة مقال
            </a>
        </div>

        {{-- Welcome Message --}}
        <p class="text-gray-600 dark:text-gray-300 mb-8 lg:mb-12 text-sm md:text-base">
            مرحبًا بك في مدونة Phoenix Soul — منصة لعرض القصص والمقالات من واقع الحياة اليومية في ظل التحديات.
        </p>

        {{-- Categories Section --}}
        <div class="px-0 sm:px-4 py-8 md:py-12">
            <h1 class="text-2xl md:text-3xl font-bold text-center text-indigo-700 dark:text-indigo-300 mb-8 md:mb-12">
                أقسام موقع Phoenix Soul
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach ($categories as $category)
                    <a href="{{ route('posts.byCategory', $category->slug) }}"
                        class="block bg-white dark:bg-gray-800 rounded-xl overflow-hidden transform transition hover:scale-[1.02] hover:-translate-y-1 shadow-md dark:shadow-gray-700 hover:shadow-lg dark:hover:shadow-xl group"
                        title="{{ $category->name }}">
                        <!-- Container for image with consistent aspect ratio -->
                        <div class="relative w-full aspect-[4/3] overflow-hidden">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                class="absolute w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="p-4">
                            <h2 class="text-lg md:text-xl font-bold text-indigo-700 dark:text-indigo-300 mb-2">
                                {{ $category->name }}
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 text-xs md:text-sm">
                                {{ $category->description }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Latest Posts Section --}}
            <section class="mb-2 mt-10 md:mb-5">
                <!-- Improved Header with Filter -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2 sm:mb-0">
                        أحدث المقالات
                    </h2>

                    <form method="GET" class="flex items-center gap-3">
                        <label for="sort" class="text-sm dark:text-gray-300 whitespace-nowrap hidden sm:block">
                            ترتيب حسب:
                        </label>
                        <select name="sort" id="sort" onchange="this.form.submit()"
                            class="rounded-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 pl-4 pr-8 shadow-sm">
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>الأحدث</option>
                            <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>الأكثر إعجابًا</option>
                        </select>
                    </form>
                </div>

                <!-- Posts Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    @forelse ($posts as $post)
                        @include('components.post-card', ['post' => $post])
                    @empty
                        @include('components.no-post')
                    @endforelse
                </div>
            </section>
        </div>
    @endsection
