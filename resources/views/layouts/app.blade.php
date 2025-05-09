{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Soul</title>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav x-data="{ isOpen: false }" class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-700"">Phoenix Soul</a>
            {{-- <div class="text-2xl font-bold text-indigo-700">Phoenix Soul</div> --}}

            <!-- Mobile menu button -->
            <button @click="isOpen = !isOpen" class="md:hidden text-gray-700 focus:outline-none">
                ☰
            </button>

            <!-- Desktop menu -->
            <ul x-show="!isOpen" x-transition
                class="hidden md:flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-reverse md:space-x-6 text-sm font-medium">
                <li><a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600">الرئيسية</a></li>

                {{-- قائمة منسدلة للأقسام --}}
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-700 hover:text-indigo-600">الأقسام ⏷</button>
                    <ul x-show="open" @click.away="open = false"
                        class="absolute bg-white shadow-md mt-2 rounded w-48 text-right z-50" x-transition>
                        <li><a href="{{ route('posts.byCategory', 'love-table') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">طاولة طعام الحب</a></li>
                        <li><a href="{{ route('posts.byCategory', 'desert-flower') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">زهرة الصحراء</a></li>
                        <li><a href="{{ route('posts.byCategory', 'health-awareness') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">التوعية الصحية</a></li>
                        <li><a href="{{ route('posts.byCategory', 'voices-of-war') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">أصوات الحرب</a></li>
                        <li><a href="{{ route('posts.byCategory', 'memories') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">منصة الذكريات</a></li>
                        <li><a href="{{ route('posts.byCategory', 'weather-tips') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">نصائح الطقس</a></li>
                    </ul>
                </li>

                @auth
                    {{-- @if (auth()->user()->hasRole('user')) --}}
                    <li>
                        <a href="{{ route('posts.my') }}" class="text-gray-700 hover:text-indigo-600">📄 مقالاتي</a>
                    </li>
                    {{-- @endif --}}
                    <li><a href="{{ route('posts.create') }}" class="text-gray-700 hover:text-indigo-600">➕ مقال جديد</a>
                    </li>
                @endauth
                <li><a href="{{ route('about') }}" class="hover:underline">حول الموقع</a></li>
                <li><a href="{{ route('terms') }}" class="hover:underline">سياسة الاستخدام</a></li>
            </ul>
            <!-- Search Box for Large Screens -->
            <form x-show="!isOpen" x-transition action="{{ route('posts.search') }}" method="GET"
                class="hidden md:flex items-center space-x-2 space-x-reverse">
                <input type="text" name="q" placeholder="ابحث عن مقال..."
                    class="border border-gray-300 rounded px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 text-white text-sm px-4 py-1 rounded hover:bg-indigo-700 transition">
                    بحث
                </button>
            </form>
            <!-- Auth Links -->
            <div x-show="!isOpen" x-transition class="hidden md:flex items-center space-x-4 space-x-reverse">
                @auth
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-semibold text-indigo-700 hover:underline">لوحة التحكم</a>
                        <a href="{{ route('admin.notifications') }}" class="relative group hover:text-indigo-600">
                            🛎️ إشعارات
                            @php $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0; @endphp
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @elseif(auth()->user()->hasRole('user'))
                        <a href="{{ route('user.notifications') }}" class="relative text-sm text-gray-700 hover:underline">
                            🔔 إشعاراتي
                            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                            @if ($unread > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $unread }}</span>
                            @endif
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:underline">تسجيل الخروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm hover:underline">تسجيل الدخول</a>
                    <a href="{{ route('register') }}" class="text-sm hover:underline">إنشاء حساب</a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" x-transition class="mt-2 md:hidden bg-white shadow p-4 space-y-2">
            <ul class="space-y-2 text-right">
                <li><a href="{{ route('home') }}" class="block text-gray-700 hover:text-indigo-600">الرئيسية</a></li>
                <li x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-700 hover:text-indigo-600">الأقسام ⏷</button>
                    <ul x-show="open" @click.away="open = false"
                        class="absolute bg-white shadow-md mt-2 rounded w-48 text-right z-50" x-transition>
                        <li><a href="{{ route('posts.byCategory', 'love-table') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">طاولة طعام الحب</a></li>
                        <li><a href="{{ route('posts.byCategory', 'desert-flower') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">زهرة الصحراء</a></li>
                        <li><a href="{{ route('posts.byCategory', 'health-awareness') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">التوعية الصحية</a></li>
                        <li><a href="{{ route('posts.byCategory', 'voices-of-war') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">أصوات الحرب</a></li>
                        <li><a href="{{ route('posts.byCategory', 'memories') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">منصة الذكريات</a></li>
                        <li><a href="{{ route('posts.byCategory', 'weather-tips') }}"
                                class="block px-4 py-2 hover:bg-indigo-100">نصائح الطقس</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('posts.create') }}" class="block text-gray-700 hover:text-indigo-600">➕ مقال
                        جديد</a></li>
                <li><a href="{{ route('about') }}" class="block hover:underline">حول الموقع</a></li>
                <li><a href="{{ route('terms') }}" class="block hover:underline">سياسة الاستخدام</a></li>
                @auth
                    {{-- @if (auth()->user()->hasRole('user')) --}}
                    <li><a href="{{ route('posts.my') }}" class="block text-gray-700 hover:text-indigo-600">📄
                            مقالاتي</a>
                    </li>
                    {{-- @endif --}}
                @endauth
            </ul>

            <!-- Auth Links on Mobile -->
            <div class="px-4 py-2 space-y-3 border-t border-gray-200">
                @auth
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}"
                            class="block text-sm text-indigo-700 hover:text-indigo-900 font-semibold">لوحة التحكم</a>
                        <a href="{{ route('admin.notifications') }}"
                            class="block text-sm text-gray-700 hover:text-indigo-600 relative">
                            🛎️ إشعارات
                            @php $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0; @endphp
                            @if ($unreadCount > 0)
                                <span
                                    class="absolute -top-1 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    @elseif(auth()->user()->hasRole('user'))
                        <a href="{{ route('user.notifications') }}"
                            class="block text-sm text-gray-700 hover:text-indigo-600 relative">
                            🔔 إشعاراتي
                            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                            @if ($unread > 0)
                                <span
                                    class="absolute -top-1 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">{{ $unread }}</span>
                            @endif
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left text-sm text-red-600 hover:text-red-800">تسجيل الخروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-sm text-gray-700 hover:text-indigo-600">تسجيل
                        الدخول</a>
                    <a href="{{ route('register') }}" class="block text-sm text-gray-700 hover:text-indigo-600">إنشاء
                        حساب</a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Search Form on Mobile -->
    <div class="p-4 md:hidden">
        <form action="{{ route('posts.search') }}" method="GET" class="w-full">
            <input type="text" name="q" placeholder="ابحث عن مقال..." class="border rounded p-2 w-full">
            <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-1 rounded w-full">بحث</button>
        </form>
    </div>



    <!-- Content -->
    <main class="flex-grow max-w-5xl mx-auto p-4 md:p-6 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow p-4 text-center text-sm text-gray-500">
        <p>© 2025 Phoenix Soul. جميع الحقوق محفوظة.</p>
        <div class="mt-2 space-x-4 rtl:space-x-reverse flex flex-wrap justify-center gap-2">
            <a href="{{ route('home') }}" class="hover:underline">الرئيسية</a>
            <a href="{{ route('posts.byCategory', 'love-table') }}" class="hover:underline">طاولة طعام الحب</a>
            <a href="{{ route('posts.byCategory', 'desert-flower') }}" class="hover:underline">زهرة الصحراء</a>
            <a href="{{ route('posts.byCategory', 'health-awareness') }}" class="hover:underline">التوعية الصحية</a>
            <a href="{{ route('posts.byCategory', 'voices-of-war') }}" class="hover:underline">أصوات الحرب</a>
            <a href="{{ route('posts.byCategory', 'memories') }}" class="hover:underline">منصة الذكريات</a>
            <a href="{{ route('posts.byCategory', 'weather-tips') }}" class="hover:underline">نصائح الطقس</a>
            <a href="{{ route('posts.my') }}" class="hover:underline">مقالاتي</a>
            <a href="{{ route('posts.create') }}" class="hover:underline">➕ مقال جديد</a>
            <a href="{{ route('about') }}" class="hover:underline">حول الموقع</a>
            <a href="{{ route('terms') }}" class="hover:underline">سياسة الاستخدام</a>
            <a href="mailto:info@phoenixsoul.org" class="hover:underline">📧 تواصل معنا</a>
        </div>
    </footer>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- هذا مهم -->

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('assets/js/helpers/toastr-handler.js') }}"></script>
<script>
    @if(session('success'))
        window.showToast(@json(session('success')), true);
    @endif

    @if(session('error'))
        window.showToast(@json(session('error')), false);
    @endif
</script>
</body>

</html>
