{{-- resources/views/site/desert-flower.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center bg-yellow-100 p-4 rounded-lg mb-6 shadow">
            <h1 class="text-2xl font-bold text-yellow-700">🌵 زهرة الصحراء</h1>
            <a href="{{ route('posts.create') }}"
                class="bg-yellow-600 text-white px-4 py-2 rounded-full text-sm hover:bg-yellow-700">➕ إضافة مقال</a>
        </div>

        <p class="text-gray-600 mb-8 max-w-3xl">
            مساحة تُسلط الضوء على صمود وإبداع الأفراد الذين يعيشون في ظروف صعبة، وتُصوّرهم كزهور تنمو في صحراء الحياة
            القاسية.
        </p>

        <!-- عرض المقالات -->
        <section class="mb-12">
            <h2 class="text-xl font-semibold mb-4">قصص ملهمة من المجتمع</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @endforeach
            </div>
        </section>
    </div>
@endsection
