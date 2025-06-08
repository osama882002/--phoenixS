{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 dark:from-gray-800 to-white dark:to-gray-900 py-12">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 text-right">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">Phoenix Soul</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">إنشاء حساب جديد</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">الاسم</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                @error('name')<span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                @error('email')<span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                @error('password')<span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white font-semibold py-2 rounded-lg transition duration-200">
                إنشاء حساب
            </button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                لديك حساب؟
                <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    تسجيل الدخول
                </a>
            </div>
        </form>
    </div>
</div>
@endsection