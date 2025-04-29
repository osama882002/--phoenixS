{{-- resources/views/site/health-awareness.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center bg-green-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-green-700">🩺 التوعية الصحية</h1>
        <a href="{{ route('posts.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-full text-sm hover:bg-green-700">➕ إضافة مقال</a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        قسم يهدف إلى نشر الوعي الصحي بين الأفراد المتأثرين، من خلال نصائح طبية وغذائية وتمارين بسيطة باستخدام الموارد المتاحة.
    </p>

    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">مقالات صحية من المجتمع</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
    </section>
</div>
@endsection