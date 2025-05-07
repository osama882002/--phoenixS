<!-- resources/views/admin/notifications.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6">📨 إشعارات المشرف</h1>

        @if ($notifications->count())
            <div class="flex justify-between items-center mb-4">
                {{-- زر تعليم كمقروء --}}
                <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        تعليم الكل كمقروء
                    </button>
                </form>

                {{-- زر حذف المقروء --}}
                <form method="POST" action="{{ route('admin.notifications.clearRead') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        🗑️ حذف الإشعارات المقروءة
                    </button>
                </form>
            </div>
        @endif
        @if ($notifications->isEmpty())
            <div class="bg-gray-100 text-center p-4 rounded text-gray-500">🚫 لا توجد إشعارات لعرضها حالياً.</div>
        @endif


        @php
            $postNotifications = $notifications->filter(fn($n) => isset($n->data['post_id']));
            $otherNotifications = $notifications->filter(fn($n) => !isset($n->data['post_id']));
        @endphp

        <div class="space-y-6">
            @if ($postNotifications->count())
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold text-indigo-600 mb-4">📚 إشعارات المقالات</h2>
                    @foreach ($postNotifications as $notification)
                        <div id="notification-{{ $notification->id }}"
                            class="border-b border-gray-200 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                            {{-- محتوى الإشعار --}}
                            <p class="text-gray-800 font-medium">
                                📨 {{ $notification->data['message'] ?? 'تم إرسال مقال جديد للمراجعة.' }}
                            </p>

                            @if (isset($notification->data['title']))
                                <p class="text-sm text-gray-600 mt-1">📌 عنوان المقال:
                                    <strong>{{ $notification->data['title'] }}</strong>
                                </p>
                            @endif
                            @if (isset($notification->data['author']))
                                <p class="text-sm text-gray-600">✍️ بواسطة:
                                    <strong>{{ $notification->data['author'] }}</strong>
                                </p>
                            @endif

                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>

                            {{-- الأزرار --}}
                            <div class="flex gap-3 mt-2">
                                @php
                                    $post = \App\Models\Post::find($notification->data['post_id']);
                                @endphp

                                @if ($post && $post->status === 'approved')
                                    <a href="{{ route('posts.show', $post->id) }}"
                                        class="inline-block mt-2 text-indigo-600 text-sm hover:underline">مراجعة المقال
                                        ➡️</a>
                                @else
                                    <span class="text-sm text-gray-500 mt-2 inline-block">المقال غير متاح</span>
                                @endif

                                <button onclick="deleteNotification('{{ $notification->id }}')"
                                    class="text-sm text-red-600 hover:underline">🗑 حذف</button>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

            @if ($otherNotifications->count())
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold text-indigo-600 mb-4">🔔 إشعارات أخرى</h2>
                    @foreach ($otherNotifications as $notification)
                        <div id="notification-{{ $notification->id }}"
                            class="border-b border-gray-200 pb-3 mb-3 {{ $notification->read_at ? 'opacity-60' : '' }}">
                            <p class="text-gray-800">{{ $notification->data['message'] ?? 'رسالة إشعار' }}</p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>

                            <button onclick="deleteNotification('{{ $notification->id }}')"
                                class="text-xs text-red-600 hover:underline">🗑️ حذف</button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div id="toast" class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow hidden z-50">
        </div>
    </div>

    {{-- <script>
        function deleteNotification(id) {
            if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;
            fetch('/admin/notifications/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.ok ? response.json() : Promise.reject())
                .then(() => {
                    document.getElementById('notification-' + id)?.remove();
                    showToast('✅ تم حذف الإشعار');
                })
                .catch(() => showToast('❌ فشل حذف الإشعار', false));
        }

        function showToast(message, success = true) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className =
                `fixed bottom-5 right-5 px-4 py-2 rounded shadow z-50 ${success ? 'bg-green-500' : 'bg-red-500'} text-white`;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2000);
        }
    </script> --}}
@section('scripts')
<script src="{{ asset('assets/js/admin/notifications.js') }}" ></script>
@endsection
@endsection

