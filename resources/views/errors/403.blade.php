{{-- resources/views/errors/403.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 text-center p-4 sm:p-6 lg:p-8">
    <div class="max-w-md w-full space-y-6">
        {{-- الرمز الخطأ --}}
        <div class="flex justify-center">
            <span class="text-5xl sm:text-6xl lg:text-7xl font-bold text-red-600 dark:text-red-400">403</span>
        </div>

        {{-- رسالة الخطأ --}}
        <div class="space-y-3">
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold text-gray-800 dark:text-gray-200">
                ليس لديك صلاحية الوصول إلى هذه الصفحة
            </h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                يرجى التأكد من أنك تملك الصلاحيات الكافية أو العودة إلى الصفحة الرئيسية.
            </p>
        </div>

        {{-- زر العودة --}}
        <div class="pt-4">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-5 py-2 sm:px-6 sm:py-3 text-sm sm:text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition duration-200 shadow-sm hover:shadow-md">
                العودة للرئيسية
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection