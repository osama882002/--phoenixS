{{-- resources/views/site/memories.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center bg-purple-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-purple-700">📸 منصة الذكريات</h1>
        <a href="{{ route('posts.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm hover:bg-purple-700">➕ إضافة مقال</a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        مساحة رقمية لحفظ الذكريات التي فقدها الناس بسبب النزوح أو الحرب، والمساعدة في إبقاء قصصهم حية.
    </p>

    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">ذكريات من الماضي</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
    @include('components.post-card', ['post' => $post])
@endforeach
        </div>
    </section>
</div>
@endsection