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
                    <th class="py-3 px-6 text-center">خيارات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-b">
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

<script>
function deletePost(postId) {
    if (!confirm('هل تريد بالتأكيد حذف هذا المقال؟')) return;

    fetch(`/admin/posts/${postId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('تم حذف المقال ✅');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('❌ حدث خطأ أثناء الحذف.');
        }
    })
    .catch(error => {
        console.error(error);
        showToast('❌ فشل الحذف.');
    });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.remove('hidden');

    setTimeout(() => {
        toast.classList.add('hidden');
    }, 2000);
}
</script>
@endsection
