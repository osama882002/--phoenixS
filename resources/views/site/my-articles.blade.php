{{-- resources/views/site/my-articles.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center bg-indigo-100 p-4 rounded-lg mb-6 shadow">
            <h1 class="text-2xl font-bold text-indigo-700">✍️ مقالاتي</h1>
            <a href="{{ route('posts.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700">➕ إضافة مقال</a>
        </div>

        <form method="GET" class="flex flex-wrap gap-4 mb-6">
            <div>
                <label for="status" class="block text-sm mb-1">الحالة</label>
                <select name="status" id="status" class="rounded border-gray-300">
                    <option value="">الكل</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>منشور</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>

            <div>
                <label for="category" class="block text-sm mb-1">القسم</label>
                <select name="category" id="category" class="rounded border-gray-300">
                    <option value="">الكل</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="sort" class="block text-sm mb-1">ترتيب حسب</label>
                <select name="sort" id="sort" class="rounded border-gray-300">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>الأكثر إعجابًا</option>
                </select>
            </div>

            <div class="self-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">تصفية</button>
            </div>
        </form>

        @if ($posts->isEmpty())
            <div class="bg-gray-100 text-center p-4 text-gray-600 rounded">
                لا توجد مقالات مطابقة للتصفية.
            </div>
        @else
        <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    @include('components.post-card', [
                        'post' => $post,
                        'showStatus' => true,
                        'showActions' => true,
                    ])
                @endforeach

            </div>
        @endif
    </div>
@endsection
