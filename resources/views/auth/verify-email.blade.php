<!-- resources/views/auth/verify-email.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 p-4">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">تأكيد البريد الإلكتروني</h1>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
                تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.
            </div>
        @endif

        <p class="text-gray-700 text-sm mb-6">
            شكرًا لتسجيلك! قبل أن تبدأ، يرجى تأكيد بريدك الإلكتروني عبر الرابط الذي أرسلناه لك.
            إذا لم يصلك البريد، يمكننا إرسال رابط آخر.
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                إعادة إرسال رابط التحقق
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">
                تسجيل الخروج
            </button>
        </form>
    </div>
</div>
@endsection
