{{-- resources/views/site/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold text-indigo-700 mb-4">تعديل المقال</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- <div>
            <label class="block text-sm font-medium text-gray-700">عنوان المقال</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        </div> --}}

        <div>
            <label class="block text-sm font-medium text-gray-700">نص المقال</label>
            <textarea name="body" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('body', $post->body) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">استبدال الوسائط (اختياري)</label>
            <input type="file" name="media" accept="image/*,video/*" class="mt-1 block w-full text-sm text-gray-500">
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">تحديث</button>
        </div>
    </form>
</div>
@endsection
