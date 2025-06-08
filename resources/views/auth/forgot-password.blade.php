{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900 p-4">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-indigo-700 dark:text-indigo-300 text-center mb-6">نسيت كلمة المرور</h1>

        @if (session('status'))
            <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-3 rounded mb-4 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">

                @error('email')
                    <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white font-semibold py-2 px-4 rounded transition duration-200">
                    إرسال رابط إعادة تعيين كلمة المرور
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}"
                   class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">العودة إلى تسجيل الدخول</a>
            </div>
        </form>
    </div>
</div>
@endsection