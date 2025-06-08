{{-- resources/views/auth/confirm-password.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900 p-4">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-6">تأكيد كلمة المرور</h1>

        <p class="text-gray-700 dark:text-gray-300 text-sm mb-6">
            هذه منطقة آمنة في التطبيق. الرجاء تأكيد كلمة المرور الخاصة بك قبل المتابعة.
        </p>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">كلمة المرور</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-indigo-500 focus:border-indigo-500">

                @error('password')
                    <span class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white font-semibold py-2 px-4 rounded transition duration-200">
                    تأكيد كلمة المرور
                </button>
            </div>
        </form>
    </div>
</div>
@endsection