{{-- resources/views/site/memories.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-center bg-purple-100 dark:bg-purple-900 p-4 rounded-lg mb-6 shadow dark:shadow-md dark:shadow-purple-900/30">
        <h1 class="text-xl sm:text-2xl font-bold text-purple-700 dark:text-purple-300 mb-3 sm:mb-0">📸 منصة الذكريات</h1>
        <a href="{{ route('posts.create') }}" class="bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white px-4 py-2 rounded-full text-sm transition duration-200 w-full sm:w-auto text-center">
            ➕ إضافة مقال
        </a>
    </div>

    {{-- Description --}}
    <p class="text-gray-600 dark:text-gray-300 mb-8 text-sm sm:text-base max-w-3xl">
        مساحة رقمية لحفظ الذكريات التي فقدها الناس بسبب النزوح أو الحرب، والمساعدة في إبقاء قصصهم حية.
    </p>

    {{-- Posts Section --}}
    <section class="mb-12">
        <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">ذكريات من الماضي</h2>
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