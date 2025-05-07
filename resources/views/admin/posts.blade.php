@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-indigo-700 mb-8">📚 إدارة جميع المقالات</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-center">#</th>
                    <th class="py-3 px-6 text-center">العنوان</th>
                    <th class="py-3 px-6 text-center">الكاتب</th>
                    <th class="py-3 px-6 text-center">القسم</th>
                    <th class="py-3 px-6 text-center">الحالة</th>
                    <th class="py-3 px-6 text-center">تاريخ الإضافة</th>
                    <th class="py-3 px-6 text-center">عرض المقال</th>
                    <th class="py-3 px-6 text-center">خيارات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr class="border-b" data-post-id="{{ $post->id }}">
                        <td class="py-3 px-6">{{ $post->id }}</td>
                        <td class="py-3 px-6">{{ $post->title }}</td>
                        <td class="py-3 px-6">{{ $post->user->name ?? '—' }}</td>
                        <td class="py-3 px-6">{{ $post->category->name ?? '—' }}</td>
                        <td class="py-3 px-6">
                            @switch($post->status)
                                @case('approved')
                                    <span class="text-green-600 font-medium">منشور</span>
                                    @break
                                @case('pending')
                                    <span class="text-yellow-600 font-medium">قيد المراجعة</span>
                                    @break
                                @case('rejected')
                                    <span class="text-red-600 font-medium">مرفوض</span>
                                    @break
                            @endswitch
                        </td>
                        <td class="py-3 px-6">{{ $post->created_at->diffForHumans() }}</td>
                        <td class="py-3 px-6"><a href="{{ route('posts.show', $post->id) }}">عرض</a></td>
                        <td class="py-3 px-6">
                            <button onclick="deletePost({{ $post->id }})"
                                    class="text-red-600 hover:underline text-sm">🗑️ حذف</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="toast" class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded hidden z-50"></div>
</div>

@section('scripts')
    <script src="{{ asset('assets/js/admin/posts.js') }}"></script>
@endsection
@endsection
