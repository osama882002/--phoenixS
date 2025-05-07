{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenix Soul</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-50 text-gray-800 font-sans">
    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="text-2xl font-bold text-indigo-700">Phoenix Soul</div>
        <ul class="flex items-center space-x-reverse space-x-4 text-sm font-medium relative">
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
                @if (auth()->user()->hasRole('user'))
                    <li>
                        <a href="{{ route('posts.my') }}" class="text-gray-700 hover:text-indigo-600">
                            📄 مقالاتي
                        </a>
                    </li>
                @endif
            @endauth
            <li><a href="{{ route('posts.create') }}" class="text-gray-700 hover:text-indigo-600">➕ مقال جديد</a></li>
            <li><a href="{{ route('about') }}" class="hover:underline">حول الموقع</a></li>
            <li><a href="{{ route('terms') }}" class="hover:underline">سياسة الاستخدام</a></li>
        </ul>
        <form action="{{ route('posts.search') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" placeholder="ابحث عن مقال..." class="border rounded p-2 w-48">
            <button type="submit" class="bg-indigo-600 text-white px-4 rounded">بحث</button>
        </form>
        @auth
            @if (auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold text-indigo-700 hover:underline">لوحة
                    التحكم</a>

                <a href="{{ route('admin.notifications') }}" class="relative group hover:text-indigo-600">
                    🛎️ إشعارات
                    @php
                        $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
                    @endphp
                    @if ($unreadCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            @endif
            @if (auth()->user()->hasRole('user'))
                <a href="{{ route('user.notifications') }}" class="relative text-sm text-gray-700 hover:underline mr-4">
                    🔔 إشعاراتي
                    @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                    @if ($unread > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ $unread }}
                        </span>
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
    </nav>

    {{-- إشعارات النجاح / الخطأ / التفاعل مع إخفاء تلقائي --}}
    @if (session('success'))
        <div id="toast-success"
            class="bg-green-100 text-green-800 px-4 py-2 text-sm text-center transition-opacity duration-500">
            {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div id="toast-error"
            class="bg-red-100 text-red-800 px-4 py-2 text-sm text-center transition-opacity duration-500">
            {{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div id="toast-warning"
            class="bg-yellow-100 text-yellow-800 px-4 py-2 text-sm text-center transition-opacity duration-500">
            {{ $errors->first() }}
        </div>
    @endif

    <audio id="notification-sound" src="https://notificationsounds.com/storage/sounds/file-sounds-1152-pristine.mp3"
        preload="auto"></audio>

    <script>
        // إخفاء التوست بعد 4 ثوانٍ
        setTimeout(() => {
            document.querySelectorAll('[id^="toast-"]').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);

        // إشعار المشرف وتحديث العدد + تشغيل صوت عند التغيير
        @auth
        @if (auth()->user()->hasRole('admin'))
            let currentCount = 0;

            function checkNotifications() {
                fetch("{{ route('admin.posts.review') }}", {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const temp = document.createElement('div');
                        temp.innerHTML = html;
                        const newCount = temp.querySelectorAll('[data-status="pending"]').length;
                        const notif = document.getElementById('notif-count');

                        if (newCount > currentCount) {
                            document.getElementById('notification-sound').play();
                        }
                        currentCount = newCount;
                        notif.textContent = newCount;
                    });
            }

            // أول تحميل
            checkNotifications();
            // تكرار كل 20 ثانية
            setInterval(checkNotifications, 20000);
        @endif
        @endauth
    </script>
    <!-- Content -->
    <main class="max-w-5xl mx-auto p-6">
        @yield('content')
    </main>

    <footer  class="bg-white shadow p-4 flex justify-between items-center">
        <p class="text-sm text-gray-500">© 2025 Phoenix Soul. جميع الحقوق محفوظة.</p> 
            <div class="mt-2 space-x-4 rtl:space-x-reverse text-indigo-700">
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

</body>


</html>
