{{-- --- Register Page (resources/views/auth/register.blade.php) --- --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-white py-12">
    <div class="max-w-md w-full bg-white shadow-lg rounded-2xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-indigo-700">Phoenix Soul</h1>
            <p class="text-sm text-gray-600 mt-2">إنشاء حساب جديد</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">الاسم</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                @error('name')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                <input type="password" name="password" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
                @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" required
                    class="mt-1 w-full rounded-lg border-gray-300 shadow-sm">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
                إنشاء حساب
            </button>

            <div class="text-center text-sm text-gray-600 mt-4">
                لديك حساب؟ <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">تسجيل الدخول</a>
            </div>
        </form>
    </div>
</div>
@endsection
