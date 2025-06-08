{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 dark:from-gray-800 to-white dark:to-gray-900 py-12">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 text-right">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300">Phoenix Soul</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">تسجيل الدخول إلى حسابك</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                @error('email')<span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm">
                @error('password')<span class="text-red-500 dark:text-red-400 text-xs">{{ $message }}</span>@enderror
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <label class="flex items-center text-sm">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        <span class="mr-2 text-gray-600 dark:text-gray-300">تذكرني</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white font-semibold py-2 rounded-lg transition duration-200">
                تسجيل الدخول
            </button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                ليس لديك حساب؟
                <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    إنشاء حساب جديد
                </a>
            </div>
        </form>
    </div>
</div>
@endsection