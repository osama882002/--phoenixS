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
                <tr class="border-b" data-user-id="{{ $user->id }}">
                    <td class="py-3 px-6">{{ $user->id }}</td>
                        <td class="py-3 px-6">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">
                            <select data-user-id="{{ $user->id }}" 
                                data-previous-role="{{ $user->roles->first()->name ?? 'user' }}"
                                onchange="updateUserRole({{ $user->id }}, this.value)" 
                                class="border rounded p-1">
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


    <script src="{{ asset('assets/js/admin/users.js') }}"></script>

@endsection
