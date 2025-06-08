{{-- resources/views/site/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-6">
    <div class="max-w-2xl mx-auto p-4 sm:p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h1 class="text-xl sm:text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-4">تعديل المقال</h1>

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Post Content --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">نص المقال</label>
                <textarea name="body" rows="5" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 p-2 text-xs sm:text-sm"
                    required>{{ old('body', $post->body) }}</textarea>
            </div>

            {{-- Category Selection --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">القسم</label>
                <select name="category_id" 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 p-2 text-xs sm:text-sm">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Media Replacement --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                    استبدال الوسائط (اختياري)
                </label>
                <input type="file" name="media" accept="image/*,video/*" 
                    class="mt-1 block w-full text-xs sm:text-sm text-gray-500 dark:text-gray-400 p-2 border rounded">
            </div>

            {{-- Current Media Preview --}}
            @php
                $extension = pathinfo($post->media_path, PATHINFO_EXTENSION);
            @endphp

            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                <div class="mt-4">
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2">الصورة الحالية:</p>
                    <img src="{{ asset('storage/' .$post->media_path) }}" alt="الصورة الحالية" 
                        class="max-w-full h-auto rounded shadow mx-auto">
                </div>
            @elseif(in_array(strtolower($extension), ['mp4', 'avi', 'mov']))
                <div class="mt-4">
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2">الفيديو الحالي:</p>
                    <video controls class="max-w-full h-auto rounded shadow mx-auto">
                        <source src="{{ asset('storage/' .$post->media_path) }}" type="video/mp4">
                        لا يدعم المستعرض الخاص بك تشغيل الفيديو.
                    </video>
                </div>
            @endif

            {{-- Submit Button --}}
            <div class="pt-2">
                <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 dark:bg-indigo-700 text-white rounded hover:bg-indigo-700 dark:hover:bg-indigo-800 transition duration-200 text-sm sm:text-base">
                    تحديث المقال
                </button>
            </div>
        </form>
    </div>
</div>
@endsection