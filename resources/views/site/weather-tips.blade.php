@extends('layouts.app')
{{-- @php
    dd('ملف Blade يعمل. متغير weatherError = ', isset($weatherError) ? $weatherError : 'غير معرف');
@endphp --}}
@section('content')
<div class="max-w-5xl mx-auto">

    {{-- العنوان وزر إضافة مقال --}}
    <div class="flex justify-between items-center bg-blue-100 p-4 rounded-lg mb-6 shadow">
        <h1 class="text-2xl font-bold text-blue-700">🌦️ نصائح الطقس</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm hover:bg-blue-700 transition">
            ➕ إضافة مقال
        </a>
    </div>

    <p class="text-gray-600 mb-8 max-w-3xl">
        دليل عملي لمساعدة الناس على التعامل مع الظروف الجوية القاسية أثناء العيش في بيئات غير مستقرة، مع تقديم نصائح حسب الحالة الجوية.
    </p>

    {{-- رسالة في حال حدوث خطأ --}}
    @if($weatherError)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <p>❌ لا يمكن جلب بيانات الطقس حالياً. يرجى المحاولة لاحقاً.</p>
        </div>
    @endif

    {{-- قسم تحديد الموقع --}}
    @if(!isset($weather) && !$weatherError)
        <div id="weather-container" class="bg-blue-100 p-6 rounded-lg mb-6 text-center shadow">
            <h3 class="text-lg font-medium text-blue-800 mb-4">احصل على نصائح الطقس حسب موقعك الحالي</h3>
            <button onclick="getLocation()" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition">
                🌍 تحديد موقعي تلقائيًا
            </button>
            <p class="text-sm text-gray-600 mt-3">سنطلب إذنك للوصول إلى موقعك لتقديم نصائح دقيقة</p>
        </div>
    @endif

    {{-- عرض الطقس --}}
    @if(isset($weather))
        <div class="bg-blue-100 p-6 rounded-lg mb-6 shadow">
            <h3 class="text-lg font-bold text-blue-900 mb-4">📍 الطقس الحالي في {{ data_get($weather, 'name', 'موقعك') }}</h3>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <img src="http://openweathermap.org/img/wn/{{ data_get($weather, 'weather.0.icon', '01d') }}@2x.png"
                     alt="{{ data_get($weather, 'weather.0.description', '') }}"
                     class="w-20 h-20">
                <div>
                    <p class="text-3xl font-bold text-gray-800">
                        {{ round(data_get($weather, 'main.temp', 0)) }}°م
                    </p>
                    <p class="capitalize text-gray-600">
                        {{ data_get($weather, 'weather.0.description', '') }}
                    </p>
                    <p class="text-sm text-gray-500">الرطوبة: {{ data_get($weather, 'main.humidity', 0) }}%</p>
                    <p class="text-sm text-gray-500">الرياح: {{ data_get($weather, 'wind.speed', 0) }} م/ث</p>
                </div>
            </div>
        </div>

        {{-- نصيحة بناءً على الحالة --}}
        <div class="bg-white p-6 rounded-lg shadow mb-10">
            <h2 class="text-xl font-semibold mb-4">🌤️ نصيحة حسب حالة الطقس</h2>
            @php
                $condition = data_get($weather, 'weather.0.main', '');
                $temp = data_get($weather, 'main.temp', 0);
                $humidity = data_get($weather, 'main.humidity', 0);
            @endphp

            @switch($condition)
                @case('Clear')
                    @if($temp > 35)
                        ☀️ <strong>حر شديد!</strong> تجنب الخروج نهاراً واشرب الكثير من الماء.
                    @elseif($temp > 25)
                        ☀️ <strong>جو مشمس دافئ:</strong> مناسب للخروج، لكن لا تنسَ واقي الشمس.
                    @else
                        ☀️ <strong>جو مشمس معتدل:</strong> الأجواء لطيفة، احرص على ارتداء سترة خفيفة.
                    @endif
                    @break
                @case('Rain')
                    🌧️ <strong>أمطار:</strong> احمل مظلة وانتبه للطرق الزلقة.
                    @break
                @case('Snow')
                    ❄️ <strong>ثلوج:</strong> ارتدِ ملابس دافئة وكن حذراً أثناء التنقل.
                    @break
                @case('Clouds')
                    ⛅ <strong>غيوم:</strong> أجواء ملبدة، تحسب لأي تغير مفاجئ.
                    @break
                @default
                    🌦️ <strong>طقس غير مستقر:</strong> تابع تحديثات الطقس بشكل متواصل.
            @endswitch

            @if($humidity > 70)
                <div class="mt-3 text-blue-800">
                    💧 الرطوبة مرتفعة (%{{ $humidity }}). تأكد من تهوية المكان جيدًا.
                </div>
            @endif
        </div>
    @endif

    {{-- النصائح المجتمعية --}}
    <section class="mb-12">
        <h2 class="text-xl font-semibold mb-4">📚 نصائح مجتمعية</h2>
        @if(isset($posts) && count($posts) > 0)
            <div class="grid md:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @endforeach
            </div>
        @else
            <div class="bg-gray-100 p-6 rounded-lg text-center text-gray-500">
                لا توجد نصائح حالياً. يمكنك إضافة مقال جديد!
            </div>
        @endif
    </section>
</div>

{{-- سكربت تحديد الموقع --}}
<script src="{{ asset('assets/js/posts/weather.js') }}"></script>
@endsection
