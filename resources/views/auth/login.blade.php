{{-- --- Login Page (resources/views/auth/login.blade.php) --- --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-white py-12">
    <div class="max-w-md w-full bg-white shadow-lg rounded-2xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700">Phoenix Soul</h1>
            <p class="text-sm text-gray-600 mt-2">تسجيل الدخول إلى حسابك</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <label class="flex items-center text-sm">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        <span class="ml-2 text-gray-600">تذكرني</span>
                    </label>
                </div>
                <div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                            نسيت كلمة المرور؟
                        </a>
                    @endif
                </div>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
                تسجيل الدخول
            </button>

            <div class="text-center text-sm text-gray-600 mt-4">
                ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">إنشاء حساب جديد</a>
            </div>
        </form>
    </div>
</div>
@endsection

