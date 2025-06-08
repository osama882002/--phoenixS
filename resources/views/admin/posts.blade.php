{{-- resources/views/admin/posts.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <x-admin.sidebar active="posts" />

    <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        <h1 class="text-2xl md:text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-6">📚 جميع المقالات</h1>

        {{-- جدول المقالات --}}
        <div class="bg-white dark:bg-gray-700 shadow rounded-xl overflow-x-auto dark:shadow-md dark:shadow-gray-700/30">
            <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-center">#</th>
                        <th class="py-3 px-6 text-center">المحتوى</th>
                        <th class="py-3 px-6 text-center">الكاتب</th>
                        <th class="py-3 px-6 text-center">القسم</th>
                        <th class="py-3 px-6 text-center">الحالة</th>
                        <th class="py-3 px-6 text-center">التاريخ</th>
                        <th class="py-3 px-6 text-center">خيارات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr class="border-b dark:border-gray-600 text-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="py-3 px-6 font-bold text-gray-600 dark:text-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-3 px-6">{{ Str::limit($post->body ?? 'بدون محتوى', 40) }}</td>
                            <td class="py-3 px-6 font-medium">{{ $post->user->name }}</td>
                            <td class="py-3 px-6">{{ $post->category->name ?? '-' }}</td>
                            <td class="py-3 px-6">
                                @php
                                    $statusMap = [
                                        'approved' => ['label' => 'منشور', 'class' => 'text-green-500'],
                                        'pending' => ['label' => 'قيد المراجعة', 'class' => 'text-yellow-500'],
                                        'rejected' => ['label' => 'مرفوض', 'class' => 'text-red-500'],
                                    ];
                                    $statusInfo = $statusMap[$post->status] ?? ['label' => $post->status, 'class' => 'text-gray-500'];
                                @endphp
                                <span class="font-semibold {{ $statusInfo['class'] }}">
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-sm">{{ $post->created_at->format('Y-m-d') }}</td>
                            <td class="py-3 px-6 flex justify-center gap-3">
                                <a href="{{ route('posts.show', $post->id) }}" target="_blank"
                                   class="text-blue-600 dark:text-blue-400 hover:underline text-sm">👁️ عرض</a>
                                <button onclick="deletePost({{ $post->id }})"
                                    class="text-red-600 dark:text-red-400 hover:underline text-sm">🗑️ حذف</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif

        {{-- Toast --}}
        <div id="toast"
            class="fixed bottom-5 right-5 bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded shadow hidden z-50">
        </div>
    </main>
</div>

<script src="{{ asset('assets/js/admin/posts.js') }}"></script>
@endsection
