@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-indigo-700">نتائج البحث عن: "{{ $query }}"</h1>
        <p class="text-gray-600 mt-1">عدد النتائج: {{ $posts->count() }}</p>
    </div>

    @if ($posts->isEmpty())
        <div class="bg-yellow-100 p-4 rounded text-yellow-800">لم يتم العثور على نتائج.</div>
    @else
        <div class="space-y-6">
            @foreach ($posts as $post)
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-600">القسم: {{ $post->category->name }} | الكاتب: {{ $post->user->name }}</p>
                    <p class="text-gray-700 mt-2">{{ Str::limit($post->body, 200) }}</p>
                </div>
            @endforeach
        </div>
    @endif
@endsection
