{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 text-center p-8">
    <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">ليس لديك صلاحية الوصول إلى هذه الصفحة</h2>
    <p class="text-gray-600 mb-6">يرجى التأكد من أنك تملك الصلاحيات الكافية أو العودة إلى الصفحة الرئيسية.</p>
    <a href="{{ route('home') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
        العودة للرئيسية
    </a>
</div>
@endsection
