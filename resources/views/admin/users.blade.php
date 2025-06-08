{{-- resources/views/admin/users.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    {{-- Sidebar --}}
    <x-admin.sidebar active="users" />

    {{-- Main --}}
    <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-8">👥 إدارة المستخدمين</h1>

        {{-- 🔍 بحث --}}
        <div class="mb-6">
            <input type="text" id="userSearch" placeholder="🔍 ابحث عن مستخدم..."
                class="w-full md:w-1/2 px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:focus:ring-indigo-600"
                oninput="filterUsers()">
        </div>

        {{-- 📋 جدول --}}
        <div class="bg-white dark:bg-gray-700 shadow-lg rounded-xl overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
                <thead class="bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-100">
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
                        <tr class="border-b dark:border-gray-600 text-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="py-3 px-6">{{ $user->id }}</td>
                            <td class="py-3 px-6 font-semibold">{{ $user->name }}</td>
                            <td class="py-3 px-6">{{ $user->email }}</td>
                            <td class="py-3 px-6">
                                @if ($user->hasRole('super-admin'))
                                    <span class="text-indigo-600 dark:text-indigo-300 font-bold">سوبر أدمن</span>
                                @elseif(auth()->user()->hasRole('super-admin'))
                                    <select onchange="updateUserRole({{ $user->id }}, this.value)"
                                        class="rounded px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm">
                                        <option value="user" {{ $user->hasRole('user') ? 'selected' : '' }}>مستخدم</option>
                                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>مشرف</option>
                                    </select>
                                @else
                                    <span class="text-sm text-gray-800 dark:text-gray-200">
                                        {{ $user->getRoleNames()->first() ?? 'غير معروف' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-6">
                                @if (!$user->hasRole('super-admin') && auth()->user()->hasRole('super-admin'))
                                    <button onclick="deleteUser({{ $user->id }})"
                                        class="text-red-600 dark:text-red-400 hover:underline text-sm">🗑️ حذف</button>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500 text-sm">غير متاح</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- 🟢 Toast --}}
        <div id="toast"
            class="fixed bottom-5 right-5 bg-green-600 dark:bg-green-700 text-white px-4 py-2 rounded shadow-lg hidden z-50">
        </div>
    </main>
</div>

<script src="{{ asset('assets/js/admin/users.js') }}"></script>
@endsection
