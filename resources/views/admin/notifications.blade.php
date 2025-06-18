{{-- resources/views/admin/notifications.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row min-h-screen">
        <x-admin.sidebar active="notifications" />
        <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-6">📨 إشعارات المشرف</h1>

            @if ($notifications->count())
                <div class="flex justify-between items-center mb-4">
                    <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                        @csrf
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white px-4 py-2 rounded">
                            ✅ تعليم الكل كمقروء
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.notifications.clearRead') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-2 rounded">
                            🗑️ حذف الإشعارات المقروءة
                        </button>
                    </form>
                </div>
            @endif

            @if ($notifications->isEmpty())
                <div class="bg-gray-100 dark:bg-gray-700 text-center p-4 rounded text-gray-500 dark:text-gray-400">
                    🚫 لا توجد إشعارات لعرضها حالياً.
                </div>
            @endif

            @php
                $postNotifications = $notifications->filter(function ($n) {
                    return isset($n->data['post_id']) && ($n->data['type'] ?? null) !== 'post_reviewed';
                });
                $roleChangeNotifications = $notifications->filter(
                    fn($n) => ($n->data['type'] ?? null) === 'role_changed',
                );

                $otherNotifications = $notifications->filter(function ($n) {
                    $type = $n->data['type'] ?? null;
                    return !isset($n->data['post_id']) && $type !== 'role_changed';
                });
            @endphp

            <div class="space-y-6">
                @if ($notifications->count())
                    @role('super-admin')
                        {{-- إشعارات الادمن (مراجعة المقالات) --}}
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow dark:shadow-md dark:shadow-gray-700/30">
                            <h2 class="text-lg font-semibold text-indigo-600 dark:text-indigo-300 mb-4">🧑‍💻 إشعارات الادمن
                            </h2>
                            @foreach ($notifications as $notification)
                                @if (($notification->data['type'] ?? null) === 'post_reviewed')
                                    {{-- إشعار مراجعة المقال من الأدمن --}}
                                    <div id="notification-{{ $notification->id }}"
                                        class="border-b border-gray-200 dark:border-gray-600 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                        <p class="text-indigo-700 dark:text-indigo-300 font-semibold">
                                            {{ $notification->data['title'] ?? 'إشعار' }}
                                        </p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        @php
                                            $url =
                                                $notification->data['url'] ??
                                                route('posts.show', $notification->data['post_id'] ?? 0);
                                        @endphp
                                        <a href="{{ $url }}"
                                            class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            🔗 عرض المقال
                                        </a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endrole
                @endif

                {{-- إشعارات المقالات (إرسال، قيد المراجعة) --}}
                @if ($postNotifications->count())
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow dark:shadow-md dark:shadow-gray-700/30">
                        <h2 class="text-lg font-semibold text-indigo-600 dark:text-indigo-300 mb-4">📚 إشعارات المقالات</h2>
                        @foreach ($postNotifications as $notification)
                            <div id="notification-{{ $notification->id }}"
                                class="border-b border-gray-200 dark:border-gray-600 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <p class="text-gray-800 dark:text-gray-200 font-medium">
                                    📨 {{ $notification->data['message'] ?? 'تم إرسال مقال جديد للمراجعة.' }}
                                </p>
                                @if (isset($notification->data['title']))
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        📌 عنوان المقال: <strong>{{ $notification->data['title'] }}</strong>
                                    </p>
                                @endif
                                @if (isset($notification->data['author']))
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        ✍️ بواسطة: <strong>{{ $notification->data['author'] }}</strong>
                                    </p>
                                @endif
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                                <div class="flex gap-3 mt-2">
                                    @php $post = \App\Models\Post::find($notification->data['post_id']); @endphp
                                    @if ($post)
                                        @if ($post->status === 'approved')
                                            <a href="{{ route('posts.show', $post->id) }}"
                                                class="text-indigo-600 dark:text-indigo-400 text-sm hover:underline">عرض
                                                المقال ➡️</a>
                                        @elseif ($post->status === 'pending')
                                            <a href="{{ route('admin.posts.review') }}"
                                                class="text-amber-600 dark:text-amber-400 text-sm hover:underline">اذهب
                                                للمراجعة ➡️</a>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">المقال غير متاح</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">المقال غير متاح</span>
                                    @endif

                                    <button onclick="deleteNotification('{{ $notification->id }}')"
                                        class="text-sm text-red-600 dark:text-red-400 hover:underline">🗑 حذف</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


                @if ($roleChangeNotifications->count())
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow dark:shadow-md dark:shadow-gray-700/30">
                        <h2 class="text-lg font-semibold text-indigo-600 dark:text-indigo-300 mb-4">🔁 إشعارات تغيير الأدوار
                        </h2>

                        @foreach ($roleChangeNotifications as $notification)
                            <div id="notification-{{ $notification->id }}"
                                class="border-b border-gray-200 dark:border-gray-600 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">

                                <p class="text-gray-800 dark:text-gray-200">
                                    {{ $notification->data['message'] }}
                                </p>

                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>

                                <button onclick="deleteNotification('{{ $notification->id }}')"
                                    class="text-xs text-red-600 dark:text-red-400 hover:underline mt-2">
                                    🗑️ حذف
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- إشعارات أخرى --}}
                @if ($otherNotifications->count())
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow dark:shadow-md dark:shadow-gray-700/30">
                        <h2 class="text-lg font-semibold text-indigo-600 dark:text-indigo-300 mb-4">🔔 إشعارات أخرى</h2>
                        @foreach ($otherNotifications as $notification)
                            @if (isset($notification->data['new_role']))
                                <div id="notification-{{ $notification->id }}"
                                    class="border-b border-gray-200 dark:border-gray-600 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                    <p class="text-gray-800 dark:text-gray-200">
                                        {{ $notification->data['message'] }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                    <button onclick="deleteNotification('{{ $notification->id }}')"
                                        class="text-xs text-red-600 dark:text-red-400 hover:underline">🗑️ حذف</button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Toast --}}
            <div id="toast"
                class="fixed bottom-5 right-5 bg-green-500 dark:bg-green-700 text-white px-4 py-2 rounded shadow hidden z-50">
            </div>
        </main>
    </div>
    @push('styles')
        <style>
            .notification-item {
                transition: opacity 0.3s ease;
            }
        </style>
    @endpush
    <script src="{{ asset('assets/js/admin/notifications.js') }}"></script>
@endsection
