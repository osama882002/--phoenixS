@extends('layouts.app')
@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">الإشعارات 🔔</h1>

        <div class="mb-4">
            <form action="{{ route('user.notifications.read') }}" method="POST">
                @csrf
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    تعليم الكل كمقروء
                </button>
            </form>
        </div>

        @forelse($notifications as $notification)
            <div id="notification-{{ $notification->id }}"
                class="bg-white shadow p-4 rounded mb-4 {{ $notification->read_at ? 'opacity-60' : '' }}">
                <p class="text-gray-800">{{ $notification->data['message'] ?? 'رسالة إشعار' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>

                @if (isset($notification->data['post_id']))
                    <a href="{{ route('posts.show', $notification->data['post_id']) }}"
                        class="inline-block mt-2 text-indigo-600 text-sm hover:underline">عرض المقال ➡️</a>
                @endif

                <button onclick="deleteNotification('{{ $notification->id }}')"
                    class="ml-4 text-sm text-red-600 hover:underline">🗑️ حذف</button>
            </div>
        @empty
            <div class="bg-gray-100 text-center p-4 text-gray-600 rounded">
                لا توجد إشعارات لعرضها حاليًا.
            </div>
        @endforelse
    </div>
    <div id="toast-success"
        class="hidden fixed bottom-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500 z-50 opacity-0">
        ✅ تم حذف الإشعار بنجاح!
    </div>

    <script>
        function deleteNotification(id) {
            if (!confirm('هل أنت متأكد أنك تريد حذف هذا الإشعار؟')) {
                return;
            }

            fetch('/notifications/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('notification-' + id)?.remove();
                        showToast();
                    } else {
                        alert('حدث خطأ أثناء الحذف.');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('حدث خطأ أثناء الاتصال.');
                });
        }

        function showToast() {
            const toast = document.getElementById('toast-success');
            toast.classList.remove('hidden');
            toast.classList.remove('opacity-0');
            toast.classList.add('opacity-100');

            setTimeout(() => {
                toast.classList.add('opacity-0');
            }, 2000);

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 2500);
        }
    </script>
@endsection
