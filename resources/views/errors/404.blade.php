{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-white dark:bg-gray-900 text-center p-4 sm:p-6 lg:p-8">
    <div class="max-w-md w-full space-y-6">
        {{-- الرسم التوضيحي --}}
        <div class="flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 sm:h-32 w-auto text-indigo-500 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        {{-- رمز الخطأ --}}
        <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-indigo-700 dark:text-indigo-300">404</h1>

        {{-- رسالة الخطأ --}}
        <div class="space-y-3">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-800 dark:text-gray-200">
                الصفحة غير موجودة
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                يبدو أنك تحاول الوصول إلى صفحة غير متوفرة أو تم نقلها.
            </p>
        </div>

        {{-- زر العودة --}}
        <div class="pt-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-5 py-2 sm:px-6 sm:py-3 text-sm sm:text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition duration-200 shadow-sm hover:shadow-md">
                العودة إلى الصفحة الرئيسية
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection