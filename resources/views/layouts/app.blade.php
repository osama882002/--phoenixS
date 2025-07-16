<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="darkMode()" :class="{ 'dark': dark }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Content-Language" content="ar">
    <title>Phoenix Soul</title>
    {{-- Meta Tags للسيو --}}
    <meta name="description" content="موقع Phoenix Soul – منصة سرد قصص الناجين من الحروب وتجاربهم بشكل إبداعي وإنساني.">
    <meta name="keywords" content="Phoenix Soul, أصوات الحرب, سرد القصص, مقالات صحية, مقالات نفسية, نصائح الطقس">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- ربط ملفات CSS/JS عبر Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- 🌓 الوضع الداكن قبل تحميل الصفحة --}}
    <script>
        if (
            localStorage.getItem('dark') === 'true' ||
            (!localStorage.getItem('dark') && window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans min-h-screen flex flex-col">
    <!-- شريط التقدم العلوي -->
    <div class="fixed top-0 left-0 right-0 h-1 bg-gray-200 dark:bg-gray-700 z-50">
        <div class="h-full bg-indigo-600 dark:bg-indigo-400 transition-all duration-300 ease-out" id="progress-bar">
        </div>
    </div>

    <!-- Navbar -->
    @include('components.navbar')

    {{-- المحتوى الرئيسي --}}
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                © <span x-text="new Date().getFullYear()"></span> Phoenix Soul. جميع الحقوق محفوظة.
            </p>
        </div>
    </footer>

    <!-- jQuery & Toastr & Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    
    {{-- Flash Messages باستخدام Toastr --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast("{{ session('success') }}", true);
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.showToast("{{ session('error') }}", false);
            });
        </script>
    @endif

    <!-- Scripts -->
    <script>
        // دالة Alpine.js لتفعيل الوضع الداكن
        function darkMode() {
            return {
                dark: localStorage.getItem('dark') === 'true' ||
                    (localStorage.getItem('dark') === null && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toggleDark() {
                    this.dark = !this.dark;
                    localStorage.setItem('dark', this.dark);
                    document.documentElement.classList.toggle('dark', this.dark);
                }
            };
        }
        // شريط التقدم
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement
                    .clientHeight;
                const scrolled = (winScroll / height) * 100;
                document.getElementById("progress-bar").style.width = scrolled + "%";
            });
        });
    </script>
</body>

</html>
