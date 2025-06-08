{{-- resources/views/site/my-articles.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="flex flex-col sm:flex-row justify-between items-center bg-indigo-100 dark:bg-indigo-900 p-4 rounded-lg mb-6 shadow dark:shadow-md dark:shadow-indigo-900/30">
        <h1 class="text-xl sm:text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-3 sm:mb-0">✍️ مقالاتي</h1>
        <a href="{{ route('posts.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white px-4 py-2 rounded-full text-sm transition duration-200 w-full sm:w-auto text-center">
            ➕ إضافة مقال
        </a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div>
            <label for="status" class="block text-sm mb-1 dark:text-gray-300">الحالة</label>
            <select name="status" id="status" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm p-2">
                <option value="">الكل</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>منشور</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
            </select>
        </div>

        <div>
            <label for="category" class="block text-sm mb-1 dark:text-gray-300">القسم</label>
            <select name="category" id="category" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm p-2">
                <option value="">الكل</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sort" class="block text-sm mb-1 dark:text-gray-300">ترتيب حسب</label>
            <select name="sort" id="sort" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm p-2">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر إعجابًا</option>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition duration-200 w-full sm:w-auto">
                تصفية
            </button>
        </div>
    </form>

    {{-- Posts List --}}
    @if ($posts->isEmpty())
        <div class="bg-gray-100 dark:bg-gray-700 text-center p-4 text-gray-600 dark:text-gray-300 rounded">
            لا توجد مقالات مطابقة للتصفية.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach ($posts as $post)
                @include('components.post-card', [
                    'post' => $post,
                    'showStatus' => true,
                    'showActions' => true,
                ])
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
</div>
@endsection