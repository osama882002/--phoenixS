{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-white text-center p-8">
    <h1 class="text-6xl font-bold text-indigo-700 mb-4">404</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">الصفحة غير موجودة</h2>
    <p class="text-gray-600 mb-6">يبدو أنك تحاول الوصول إلى صفحة غير متوفرة أو تم نقلها.</p>
    <a href="{{ route('home') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        العودة إلى الصفحة الرئيسية
    </a>
</div>
@endsection
