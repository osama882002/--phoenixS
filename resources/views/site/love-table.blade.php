{{-- resources/views/site/love-table.blade.php
@extends('layouts.app')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-pink-600">طاولة طعام الحب</h1>
        <p class="text-gray-600 mt-2 max-w-3xl mx-auto">
            قسم مخصص لعرض تجارب وتقاليد الطعام في أوقات الأزمات. يتيح هذا القسم للناس مشاركة وصفات تعكس ثقافتهم، حتى في ظل الظروف الصعبة، مع التركيز على طرق مبتكرة لإعداد وجبات الطعام باستخدام موارد محدودة.
        </p>
    </div>

    <!-- عرض المقالات الخاصة بهذا القسم -->
    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">وصفات وتجارب من المجتمع</h2>
        @foreach ($posts as $post)
            @include('components.post', ['post' => $post])
        @endforeach
    </section>

    <!-- نموذج إرسال وصفة جديدة -->
    <section class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-bold mb-4">شارك وصفتك</h2>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">اسم المستخدم</label>
                <input type="text" value="{{ auth()->user()->name ?? 'اسم المستخدم' }}" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">وصف الوصفة أو القصة</label>
                <textarea name="idea" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">صورة الطعام</label>
                <input type="file" name="media" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded hover:bg-pink-700">
                    إرسال الوصفة
                </button>
            </div>
        </form>
    </section>
@endsection --}}

{{-- resources/views/site/love-table.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center bg-pink-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-pink-600">🍽️ طاولة طعام الحب</h1>
        <a href="{{ route('posts.create') }}" class="bg-pink-600 text-white px-4 py-2 rounded-full text-sm hover:bg-pink-700">➕ إضافة مقال</a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        قسم مخصص لعرض تجارب وتقاليد الطعام في أوقات الأزمات. يتيح هذا القسم للناس مشاركة وصفات تعكس ثقافتهم، حتى في ظل الظروف الصعبة، مع التركيز على طرق مبتكرة لإعداد وجبات الطعام باستخدام موارد محدودة.
    </p>

    <!-- عرض المقالات الخاصة بهذا القسم -->
    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">🍲 وصفات وتجارب من المجتمع</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach
        </div>
    </section>
</div>
@endsection

