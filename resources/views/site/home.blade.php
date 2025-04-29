{{-- resources/views/site/home.blade.php --}}
@extends('layouts.app')

@section('content')
@auth
    <div class="bg-yellow-100 p-4 mt-4 rounded text-sm">
        دور المستخدم الحالي: 
        @foreach(auth()->user()->getRoleNames() as $role)
            <span class="font-bold text-indigo-600">{{ $role }}</span>
        @endforeach
    </div>
@endauth
<div class="flex justify-end mb-4">
    <form method="GET" class="flex items-center gap-2">
        <label for="sort" class="text-sm">ترتيب حسب:</label>
        <select name="sort" id="sort" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>الأحدث</option>
            <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>الأكثر إعجابًا</option>
        </select>
    </form>
</div>

<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center bg-indigo-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-indigo-700">🏠 الصفحة الرئيسية</h1>
        <a href="{{ route('posts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700">➕ إضافة مقال</a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        مرحبًا بك في مدونة Phoenix Soul — منصة لعرض القصص والمقالات من واقع الحياة اليومية في ظل التحديات.
    </p>

    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">أحدث المقالات</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach
        </div>
    </section>
</div>
@endsection

