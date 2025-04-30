{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-indigo-700 mb-6">لوحة تحكم المشرف</h1>





        <div class="grid md:grid-cols-3 gap-6 text-center">


            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">مقالات قيد المراجعة</h2>
                <p class="text-4xl font-bold text-red-600">{{ $pendingPosts }}</p>
                <a href="{{ route('admin.posts.review') }}"  class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                    📋عرض التفاصيل </a>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">عدد المستخدمين</h2>
                <p class="text-4xl font-bold text-green-600">{{ $usersCount }}</p>
                <!-- زر عرض المستخدمين -->
                <a href="{{ route('admin.users.index') }}"  class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                    👥 عرض جميع المستخدمين
                </a>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">إجمالي المقالات</h2>
                <p class="text-4xl font-bold text-blue-600">{{ $postsCount }}</p>
                <a href="{{ route('admin.posts.index') }}"
                    class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-full transition">
                    📚 عرض كل المقالات
                </a>
            </div>
        </div>
    </div>
@endsection
