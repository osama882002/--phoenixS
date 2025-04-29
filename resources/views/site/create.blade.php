{{-- resources/views/site/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-indigo-100 border border-indigo-300 text-indigo-800 p-4 rounded-lg shadow text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">✨ شارك قصتك أو وصفك الآن</h1>
        <p class="text-sm">اكتب لنا عن تجربتك أو أبدع بوصفة مميزة، وسنقوم بمراجعتها ونشرها قريبًا ❤️</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">إضافة مقال جديد</h2>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">اسم المستخدم</label>
                <input type="text" value="{{ auth()->user()->name }}" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">فكرة المقال / النص</label>
                <textarea name="idea" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">القسم</label>
                <select name="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">اختر القسم</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">تحميل صورة أو فيديو (اختياري)</label>
                <input type="file" name="media" accept="image/*,video/mp4" class="mt-1 block w-full text-sm text-gray-500">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-full text-lg hover:bg-indigo-700 transition">
                    🚀 إرسال المقال
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
