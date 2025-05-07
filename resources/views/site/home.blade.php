{{-- resources/views/site/home.blade.php --}}
@extends('layouts.app')

@section('content')
    @auth
        <b>
            <div class="bg-yellow-100 p-4 mt-4 rounded text-sm">
                دور المستخدم الحالي:
                @foreach (auth()->user()->getRoleNames() as $role)
                    <span class="font-bold text-indigo-600">{{ $role }}</span>
                @endforeach
                @if (Auth::check())
                    <p> مرحبا <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span> 😊</p>
                @endif
            </div>
        </b>
    @endauth
    <div class="flex justify-end mb-4">
        <form method="GET" class="flex items-center gap-2">
            <label for="sort" class="text-sm">ترتيب حسب:</label>
            <select name="sort" id="sort" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>الأحدث</option>
                <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>الأكثر إعجابًا</option>
            </select>
        </form>
    </div>

    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center bg-indigo-100 p-4 rounded-lg mb-6 shadow">
            <h1 class="text-2xl font-bold text-indigo-700">🏠 الصفحة الرئيسية</h1>
            <a href="{{ route('posts.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-full text-sm hover:bg-indigo-700">➕ إضافة مقال</a>
        </div>

        <p class="text-gray-600 mb-8 max-w-3xl">
            مرحبًا بك في مدونة Phoenix Soul — منصة لعرض القصص والمقالات من واقع الحياة اليومية في ظل التحديات.
        </p>

        {{-- عرض اقسام الموقع --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-center text-indigo-700 mb-12">أقسام موقع Phoenix Soul</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- مائدة الحب -->
                <a href="{{ route('posts.byCategory', 'love-table') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?family,dinner" alt="مائدة الحب"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">مائدة الحب</h2>
                        <p class="text-gray-600 text-sm">قصص ومقالات تنبض بالحب والعلاقات الإنسانية العميقة.</p>
                    </div>
                </a>

                <!-- زهرة الصحراء -->
                <a href="{{ route('posts.byCategory', 'desert-flower') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?desert,flower" alt="زهرة الصحراء"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">زهرة الصحراء</h2>
                        <p class="text-gray-600 text-sm">قوة البقاء والأمل وسط أقسى الظروف من خلال قصص ملهمة.</p>
                    </div>
                </a>

                <!-- الوعي الصحي -->
                <a href="{{ route('posts.byCategory', 'health-awareness') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?healthcare,medical" alt="الوعي الصحي"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">الوعي الصحي</h2>
                        <p class="text-gray-600 text-sm">مقالات ونصائح للحفاظ على الصحة والوقاية من الأمراض.</p>
                    </div>
                </a>

                <!-- أصوات الحرب -->
                <a href="{{ route('posts.byCategory', 'voices-of-war') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?war,destruction" alt="أصوات الحرب"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">أصوات الحرب</h2>
                        <p class="text-gray-600 text-sm">حكايات من قلب الحروب والصراعات الإنسانية وتأثيرها.</p>
                    </div>
                </a>

                <!-- منصة الذكريات -->
                <a href="{{ route('posts.byCategory', 'memories') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?memories,album" alt="منصة الذكريات"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">منصة الذكريات</h2>
                        <p class="text-gray-600 text-sm">تخليد اللحظات الجميلة والذكريات العزيزة في كلمات وصور.</p>
                    </div>
                </a>

                <!-- نصائح الطقس -->
                <a href="{{ route('posts.byCategory', 'weather-tips') }}"
                    class="block bg-white rounded-xl overflow-hidden transform transition duration-300 hover:scale-105 hover:-translate-y-1 shadow hover:shadow-2xl">
                    <img src="https://source.unsplash.com/600x400/?weather,clouds" alt="نصائح الطقس"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-bold text-indigo-700 mb-2">نصائح الطقس</h2>
                        <p class="text-gray-600 text-sm">استعد لكل الفصول مع نصائح عملية لمواجهة تغيرات الطقس.</p>
                    </div>
                </a>
            </div>
        </div>







        {{-- أحدث المقالات --}}
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4">أحدث المقالات</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @endforeach
            </div>
        </section>
    </div>
@endsection
