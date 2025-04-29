{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-indigo-700 mb-6">لوحة تحكم المشرف</h1>

    <div class="grid md:grid-cols-3 gap-6 text-center">
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">مقالات قيد المراجعة</h2>
            <p class="text-4xl font-bold text-red-600">{{ $pendingPosts }}</p>
            <a href="{{ route('admin.posts.review') }}" class="text-sm text-indigo-600 hover:underline mt-2 inline-block">عرض التفاصيل</a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">عدد المستخدمين</h2>
            <p class="text-4xl font-bold text-green-600">{{ $usersCount }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">إجمالي المقالات</h2>
            <p class="text-4xl font-bold text-blue-600">{{ $postsCount }}</p>
        </div>
    </div>
</div>
@endsection
