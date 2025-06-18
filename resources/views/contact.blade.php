@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-gray-800 dark:text-gray-100">
        <h1 class="text-3xl sm:text-4xl font-bold text-center text-indigo-700 dark:text-indigo-300 mb-4">
            📬 يسعدنا تواصلك معنا
        </h1>

        <p class="text-center text-gray-600 dark:text-gray-400 text-base sm:text-lg mb-10 max-w-2xl mx-auto">
            نحن هنا لنستمع إليك ❤️ سواء كان لديك استفسار، اقتراح، أو حتى كلمة طيبة – تواصلك يسعدنا ويدعمنا لنقدم الأفضل
            دائمًا.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- كل عنصر تواصل هنا --}}

            {{-- Email --}}
            <a href="mailto:contact@example.com" target="_blank"
                class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m0 0l4-4m-4 4l4 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-1">البريد الإلكتروني</h2>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400 group-hover:underline">
                            contact@example.com
                        </p>
                    </div>
                </div>
            </a>

            {{-- WhatsApp --}}
            <a href="https://wa.me/966500000000" target="_blank"
                class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.52 3.48A11.87 11.87 0 0012 0a12 12 0 00-9.17 19.85L0 24l4.35-2.83A12 12 0 1012 0c3.17 0 6.13 1.23 8.36 3.45l.16.16z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-1">واتساب</h2>
                        <p class="text-sm text-green-600 dark:text-green-400 group-hover:underline">
                            +966500000000
                        </p>
                    </div>
                </div>
            </a>

            {{-- Telegram --}}
            <a href="https://t.me/example" target="_blank"
                class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9.03 16.47l-.39 4.52c.56 0 .8-.24 1.08-.52l2.58-2.42 5.36 3.92c.99.55 1.69.27 1.96-.9L24 3.54c.31-1.29-.45-1.79-1.31-1.5L1.67 9.33c-1.27.49-1.25 1.17-.22 1.49l5.83 1.82L19.88 4.4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-1">تليجرام</h2>
                        <p class="text-sm text-blue-600 dark:text-blue-400 group-hover:underline">
                            @example
                        </p>
                    </div>
                </div>
            </a>

            {{-- Instagram --}}
            <a href="https://instagram.com/example" target="_blank"
                class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-pink-100 dark:bg-pink-900 text-pink-700 dark:text-pink-300 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.2c3.2 0 3.584.012 4.85.07 1.17.054 1.973.24 2.43.41a4.94 4.94 0 011.84 1.23 4.94 4.94 0 011.23 1.84c.17.457.356 1.26.41 2.43.058 1.265.07 1.65.07 4.85s-.012 3.584-.07 4.85c-.054 1.17-.24 1.973-.41 2.43a4.94 4.94 0 01-1.23 1.84 4.94 4.94 0 01-1.84 1.23c-.457.17-1.26.356-2.43.41-1.265.058-1.65.07-4.85.07s-3.584-.012-4.85-.07c-1.17-.054-1.973-.24-2.43-.41a4.94 4.94 0 01-1.84-1.23 4.94 4.94 0 01-1.23-1.84c-.17-.457-.356-1.26-.41-2.43C2.212 15.784 2.2 15.4 2.2 12s.012-3.584.07-4.85c.054-1.17.24-1.973.41-2.43a4.94 4.94 0 011.23-1.84 4.94 4.94 0 011.84-1.23c.457-.17 1.26-.356 2.43-.41C8.416 2.212 8.8 2.2 12 2.2zm0 1.8c-3.14 0-3.508.01-4.75.068-1.02.05-1.577.22-1.942.37a3.14 3.14 0 00-1.14.74 3.14 3.14 0 00-.74 1.14c-.15.365-.32.922-.37 1.942-.058 1.242-.068 1.61-.068 4.75s.01 3.508.068 4.75c.05 1.02.22 1.577.37 1.942.17.39.407.745.74 1.14.395.333.75.57 1.14.74.365.15.922.32 1.942.37 1.242.058 1.61.068 4.75.068s3.508-.01 4.75-.068c1.02-.05 1.577-.22 1.942-.37a3.14 3.14 0 001.14-.74 3.14 3.14 0 00.74-1.14c.15-.365.32-.922.37-1.942.058-1.242.068-1.61.068-4.75s-.01-3.508-.068-4.75c-.05-1.02-.22-1.577-.37-1.942a3.14 3.14 0 00-.74-1.14 3.14 3.14 0 00-1.14-.74c-.365-.15-.922-.32-1.942-.37-1.242-.058-1.61-.068-4.75-.068zm0 3.4a6.4 6.4 0 110 12.8 6.4 6.4 0 010-12.8zm0 10.6a4.2 4.2 0 100-8.4 4.2 4.2 0 000 8.4zm5.2-10.88a1.44 1.44 0 110-2.88 1.44 1.44 0 010 2.88z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-1">إنستغرام</h2>
                        <p class="text-sm text-pink-600 dark:text-pink-400 group-hover:underline">
                            @example
                        </p>
                    </div>
                </div>
            </a>

            {{-- Facebook --}}
            <a href="https://facebook.com/example" target="_blank"
                class="group bg-white dark:bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition hover:-translate-y-1 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.406.593 24 1.325 24H12.82v-9.294H9.692V11.31h3.128V8.41c0-3.1 1.894-4.788 4.66-4.788 1.325 0 2.464.099 2.795.143v3.24h-1.918c-1.504 0-1.796.715-1.796 1.762v2.31h3.587l-.467 3.396h-3.12V24h6.116C23.406 24 24 23.406 24 22.676V1.325C24 .593 23.406 0 22.675 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-1">فيسبوك</h2>
                        <p class="text-sm text-blue-600 dark:text-blue-400 group-hover:underline">
                            facebook.com/example
                        </p>
                    </div>
                </div>
            </a>

        </div>

        {{-- خاتمة لطيفة --}}
        <p class="text-center text-sm sm:text-base text-gray-500 dark:text-gray-400 mt-10">
            🤝 شكراً لاهتمامك، تواصلك معنا يعني لنا الكثير! سنكون سعداء بردك أو خدمتك في أي وقت.
        </p>
    </div>
@endsection
