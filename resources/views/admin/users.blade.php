<!-- resources/views/admin/users.blade.php -->
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-indigo-700 mb-8">👥 إدارة المستخدمين</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-center">#</th>
                    <th class="py-3 px-6 text-center">الاسم</th>
                    <th class="py-3 px-6 text-center">البريد الإلكتروني</th>
                    <th class="py-3 px-6 text-center">الدور</th>
                    <th class="py-3 px-6 text-center">خيارات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="py-3 px-6">{{ $user->id }}</td>
                        <td class="py-3 px-6">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">
                            <select onchange="updateUserRole({{ $user->id }}, this.value)" class="border rounded p-1">
                                <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>مستخدم</option>
                                <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>مشرف</option>
                            </select>
                        </td>
                        <td class="py-3 px-6">
                            @if(!$user->hasRole('admin'))
                                <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:underline">🗑️ حذف</button>
                            @else
                                <span class="text-gray-400">لا يمكن حذف مشرف</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="toast" class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded hidden z-50"></div>
</div>

<script>
function deleteUser(userId) {
    if (!confirm('هل تريد بالتأكيد حذف هذا المستخدم؟')) return;

    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('تم حذف المستخدم بنجاح ✅');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('❌ حدث خطأ، لم يتم الحذف.');
        }
    })
    .catch(error => console.error(error));
}

function updateUserRole(userId, role) {
    fetch(`/admin/users/${userId}/role`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('تم تحديث الدور بنجاح ✅');
        } else {
            showToast('❌ حدث خطأ أثناء التحديث.');
        }
    })
    .catch(error => console.error(error));
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
