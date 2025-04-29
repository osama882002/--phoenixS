{{-- resources/views/site/weather-tips.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-center bg-blue-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-blue-700">🌦️ نصائح الطقس</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm hover:bg-blue-700">➕ إضافة مقال</a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        دليل عملي لمساعدة الناس على التعامل مع الظروف الجوية القاسية أثناء العيش في بيئات غير مستقرة، مع تقديم نصائح حسب الحالة الجوية.
    </p>

    @if(isset($weather))
        <div class="bg-blue-200 p-4 rounded text-center mb-6">
            <h3 class="text-lg font-bold text-blue-900">الطقس الحالي في {{ $weather['name'] }}</h3>
            <p class="text-gray-800">
                {{ $weather['weather'][0]['description'] }} - {{ round($weather['main']['temp']) }}°م
            </p>
        </div>

        @php
            $condition = $weather['weather'][0]['main'];
        @endphp

        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-2">نصيحة خاصة لحالة الطقس:</h2>
            <div class="bg-white p-4 rounded shadow text-sm text-gray-700">
                @switch($condition)
                    @case('Clear')
                        ☀️ الجو مشمس! لا تنسَ وضع واقي الشمس وشرب الماء.
                        @break
                    @case('Rain')
                        🌧️ أمطار! حافظ على جفافك وابتعد عن المناطق المنخفضة.
                        @break
                    @case('Snow')
                        ❄️ تساقط ثلوج! ارتدِ ملابس دافئة ولا تخرج إلا للضرورة.
                        @break
                    @case('Clouds')
                        ⛅ الجو غائم، يُفضل الخروج بملابس مناسبة.
                        @break
                    @default
                        🌦️ تابع تحديثات الطقس للبقاء آمناً.
                @endswitch
            </div>
        </div>
    @endif

    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">نصائح مجتمعية للطقس</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($posts as $post)
            @include('components.post-card', ['post' => $post])
        @endforeach
        </div>
    </section>
</div>
@endsection