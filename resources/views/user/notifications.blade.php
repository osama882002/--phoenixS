{{-- resources/views/user/notifications.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-6 sm:py-10 px-4 sm:px-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-4 sm:mb-6">🔔 إشعاراتك</h1>

        {{-- أزرار التحكم --}}
        @if ($notifications->count())
            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 mb-6">
                <form action="{{ route('user.notifications.read') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white px-4 py-2 rounded transition duration-200 text-sm sm:text-base">
                        ✅ تعليم الكل كمقروء
                    </button>
                </form>
                <form action="{{ route('user.notifications.clear') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full sm:w-auto bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-2 rounded transition duration-200 text-sm sm:text-base">
                        🗑️ حذف جميع الإشعارات
                    </button>
                </form>
            </div>
        @endif

        {{-- عرض الإشعارات --}}
        <div class="space-y-3 sm:space-y-4">
            @forelse($notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'general';
                    $message = $notification->data['message'] ?? 'لديك إشعار جديد';
                    $postId = $notification->data['post_id'] ?? null;
                    $post = $postId ? \App\Models\Post::find($postId) : null;
                    $link = $post && $post->status === 'approved' ? route('posts.show', $post->id) : null;
                @endphp

                <div id="notification-{{ $notification->id }}"
                    class="bg-white dark:bg-gray-700 shadow p-3 sm:p-4 rounded-lg transition-all duration-300 {{ $notification->read_at ? 'opacity-60' : '' }}">

                    <div class="flex flex-col xs:flex-row justify-between items-start gap-3">
                        <div class="flex-1">
                            <p class="text-gray-800 dark:text-gray-100 font-medium text-sm sm:text-base">
                                {{ $message }}
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>

                            @if ($link)
                                <a href="{{ $link }}"
                                    class="inline-block mt-2 text-indigo-600 dark:text-indigo-400 text-xs sm:text-sm hover:underline">
                                    🔗 عرض المقال
                                </a>
                            @elseif($type === 'role_changed')
                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 inline-block mt-2">
                                    تم تغيير دورك في النظام.
                                </span>
                            @else
                                <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 inline-block mt-2">
                                    لا يوجد رابط مرتبط.
                                </span>
                            @endif
                        </div>

                        {{-- زر الحذف --}}
                        <button onclick="deleteNotification('{{ $notification->id }}')"
                            class="text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors duration-200">
                            🗑️ حذف
                        </button>

                    </div>
                </div>
            @empty
                <div
                    class="bg-gray-100 dark:bg-gray-700 text-center p-4 rounded text-gray-500 dark:text-gray-400 text-sm sm:text-base">
                    🚫 لا توجد إشعارات لعرضها حاليًا.
                </div>
            @endforelse
        </div>

        {{-- Toast --}}
        <div id="toast"
            class="fixed bottom-5 right-5 bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded shadow hidden z-50 text-sm sm:text-base">
        </div>
    </div>

    <script src="{{ asset('assets/js/user/notifications.js') }}"></script>
@endsection
