{{-- resources/views/site/weather-tips.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- العنوان وزر إضافة مقال --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-blue-100 dark:bg-blue-900 p-4 rounded-lg mb-6 shadow dark:shadow-md dark:shadow-blue-900/30">
            <h1 class="text-xl sm:text-2xl font-bold text-blue-700 dark:text-blue-300">🌦️ نصائح الطقس</h1>
            <a href="{{ route('posts.create') }}"
               class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-full text-sm transition duration-200 w-full sm:w-auto text-center">
                ➕ إضافة مقال
            </a>
        </div>

        <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-3xl text-sm sm:text-base">
            دليل عملي لمساعدة الناس على التعامل مع الظروف الجوية القاسية أثناء العيش في بيئات غير مستقرة، مع تقديم نصائح حسب الحالة الجوية.
        </p>

        {{-- رسالة خطأ الطقس --}}
        @if ($weatherError)
            <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 p-4 mb-6 rounded shadow text-sm sm:text-base">
                <p>❌ لا يمكن جلب بيانات الطقس حالياً. يرجى المحاولة لاحقاً.</p>
            </div>
        @endif

        {{-- قسم تحديد الموقع --}}
        @if (!isset($weather) && !$weatherError)
            <div id="weather-container" class="bg-blue-100 dark:bg-blue-800 p-4 sm:p-6 rounded-lg mb-6 text-center shadow dark:shadow-md">
                <h3 class="text-base sm:text-lg font-medium text-blue-800 dark:text-blue-300 mb-3 sm:mb-4">احصل على نصائح الطقس حسب موقعك الحالي</h3>
                <button onclick="getLocation()"
                        class="bg-blue-600 dark:bg-blue-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-base sm:text-lg hover:bg-blue-700 dark:hover:bg-blue-800 transition duration-200 w-full sm:w-auto">
                    🌍 تحديد موقعي تلقائيًا
                </button>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-2 sm:mt-3">سنطلب إذنك للوصول إلى موقعك لتقديم نصائح دقيقة</p>
            </div>
        @endif

        {{-- عرض حالة الطقس --}}
        @if (isset($weather))
            <div class="bg-blue-100 dark:bg-blue-800 p-4 sm:p-6 rounded-lg mb-6 shadow dark:shadow-md">
                <h3 class="text-base sm:text-lg font-bold text-blue-900 dark:text-blue-300 mb-3 sm:mb-4">
                    📍 الطقس الحالي في {{ data_get($weather, 'name', 'موقعك') }}
                </h3>
                <div class="flex flex-col xs:flex-row items-center gap-4 rtl:space-x-reverse">
                    <img src="http://openweathermap.org/img/wn/{{ data_get($weather, 'weather.0.icon', '01d') }}@2x.png"
                         alt="{{ data_get($weather, 'weather.0.description', '') }}" class="w-16 h-16 sm:w-20 sm:h-20">
                    <div class="text-center xs:text-right">
                        <p class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-gray-200">
                            {{ round(data_get($weather, 'main.temp', 0)) }}°م
                        </p>
                        <p class="capitalize text-gray-600 dark:text-gray-300 text-sm sm:text-base">
                            {{ data_get($weather, 'weather.0.description', '') }}
                        </p>
                        <div class="flex flex-wrap justify-center xs:justify-start gap-x-4 gap-y-1 mt-2">
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">الرطوبة: {{ data_get($weather, 'main.humidity', 0) }}%</p>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">الرياح: {{ data_get($weather, 'wind.speed', 0) }} م/ث</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- نصيحة بناءً على الحالة --}}
            <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow mb-10 text-sm sm:text-base">
                <h2 class="text-lg sm:text-xl font-semibold mb-3 sm:mb-4 text-gray-800 dark:text-gray-200">🌤️ نصيحة حسب حالة الطقس</h2>
                @php
                    $condition = data_get($weather, 'weather.0.main', '');
                    $temp = data_get($weather, 'main.temp', 0);
                    $humidity = data_get($weather, 'main.humidity', 0);
                @endphp

                @switch($condition)
                    @case('Clear')
                        @if ($temp > 35)
                            ☀️ <strong>حر شديد!</strong> تجنب الخروج نهارًا واشرب الكثير من الماء.
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

                @if ($humidity > 70)
                    <div class="mt-2 sm:mt-3 text-blue-800 dark:text-blue-300">
                        💧 الرطوبة مرتفعة (%{{ $humidity }}). تأكد من تهوية المكان جيدًا.
                    </div>
                @endif
            </div>
        @endif

        {{-- النصائح المجتمعية --}}
        <section class="mb-12">
            <h2 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">📚 نصائح مجتمعية</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @forelse ($posts as $post)
                    @include('components.post-card', ['post' => $post])
                @empty
                    @include('components.no-post')
                @endforelse
            </div>
        </section>
    </div>

    {{-- سكربت تحديد الموقع --}}
    <script src="{{ asset('assets/js/posts/weather.js') }}"></script>
@endsection