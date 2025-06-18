<nav x-data="{ menuOpen: false, dark: localStorage.getItem('dark') === 'true' }"
    class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        {{-- شعار الموقع وزر القائمة للجوال --}}
        <div class="flex items-center gap-2">
            <button @click="menuOpen = !menuOpen" class="p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 md:hidden"
                aria-label="فتح القائمة">
                <template x-if="!menuOpen">
                    <!-- أيقونة الهامبرغر -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </template>
                <template x-if="menuOpen">
                    <!-- أيقونة الإغلاق -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </template>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-1">
                <img src="{{ asset('phoenix_logo.png') }}" class="h-8 w-8" alt="Phoenix Soul Logo">
                <span class="text-lg font-bold text-indigo-700 dark:text-indigo-300">Phoenix Soul</span>
            </a>
                        {{-- البحث --}}
            <form action="{{ route('posts.search') }}" method="GET" class="relative flex-1">
                <input name="q" type="text" placeholder="ابحث..."
                    class="w-full px-3 py-1 rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200" />
                <button type="submit" class="absolute left-2 top-1.5 text-gray-500 dark:text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- روابط سطح المكتب --}}
        <div class="hidden md:flex items-center gap-4">
            {{-- الصفحة الرئيسية --}}
            <a href="{{ route('home') }}"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="الرئيسية">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l9-9 9 9v9a3 3 0 01-3 3H6a3 3 0 01-3-3v-9z" />
                </svg>
            </a>

            {{-- تصنيفات --}}
            <div x-data="{ openCategories: false }" class="relative">
                <button @click="openCategories = !openCategories"
                    class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="الاقسام">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div x-show="openCategories" x-cloak x-transition @click.away="openCategories = false"
                    class="absolute right-0 mt-2 bg-white dark:bg-gray-800 rounded shadow py-1 w-48 z-50">
                    @foreach ($categories as $category)
                        <a href="{{ route('posts.byCategory', $category->slug) }}"
                            class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- حول الموقع --}}
            <a href="{{ route('about') }}"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="حول الموقع">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
                </svg>
            </a>

            {{-- سياسة الاستخدام --}}
            <a href="{{ route('terms') }}"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="سياسة الاستخدام">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-3-3h-2m-4 5H7a3 3 0 01-3-3v-2h5m10-4V7a3 3 0 00-3-3h-2m-4 5V4H7a3 3 0 00-3 3v2" />
                </svg>
            </a>

            {{-- تواصل معنا --}}
            <a href="{{ route('contact') }}"
                class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="تواصل معنا">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 2H8a2 2 0 00-2 2v16l6-3.5L18 20V4a2 2 0 00-2-2z" />
                </svg>
            </a>
            @auth
                <a href="{{ route('posts.my') }}"
                    class="flex items-center gap-1 {{ request()->routeIs('posts.my') ? 'text-indigo-600 dark:text-indigo-400 font-medium border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1"
                    title="مقالاتي">

                    <!-- أيقونة المقالات -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M4 9h16M4 15h16" />
                    </svg>
                </a>
            @endauth




        </div>

        {{-- أدوات المستخدم --}}
        <div class="flex items-center gap-3">
            {{-- تبديل الوضع --}}
            <button
                @click="dark = !dark; localStorage.setItem('dark', dark); document.documentElement.classList.toggle('dark', dark)"
                class="hover:text-yellow-500 dark:hover:text-blue-400 transition duration-300">
                <span x-show="!dark" title="الوضع الفاتح">🌞</span>
                <span x-show="dark" title="الوضع الداكن">🌙</span>
            </button>
            {{-- لوحة التحكم --}}
            @auth
                @if(auth()->user()->hasRole('admin, super-admin'))
                <a href="{{ route('admin.dashboard') }}"
                    class="hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1" title="لوحة التحكم">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>

                </a>
                @endif
            @endauth

            {{-- إشعارات --}}
            @auth
                <a href="{{ auth()->user()->hasRole('admin') ? route('admin.notifications') : route('user.notifications') }}"
                    class="relative hover:text-indigo-600 dark:hover:text-indigo-400" title="الإشعارات">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if (auth()->user()->unreadNotifications->count())
                        <span
                            class="absolute -top-1 -right-1 bg-red-600 text-white rounded-full text-xs w-4 h-4 flex items-center justify-center">
                            {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            @endauth

            {{-- حساب المستخدم --}}
            @guest
                <a href="{{ route('login') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400"
                    title="تسجيل الدخول">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A2.5 2.5 0 017 16.25h10a2.5 2.5 0 011.879 1.554M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </a>
                <a href="{{ route('register') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400"
                    title="التسجيل">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
            @else
                <div class="relative" x-data="{ userDropdownOpen: false }">
                    <button @click="userDropdownOpen = !userDropdownOpen"
                        class="flex items-center gap-2 focus:outline-none group" aria-label="قائمة المستخدم">
                        <span
                            class="hidden md:inline text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                            {{ auth()->user()->name }}
                        </span>
                        <div
                            class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 {{ request()->routeIs('profile.show') ? 'border-indigo-600 dark:border-indigo-400' : 'border-transparent group-hover:border-indigo-300 dark:group-hover:border-gray-500' }}">
                            @if (auth()->user()->profile_photo_path)
                                <img src="{{ auth()->user()->profile_photo_path }}" alt="الصورة"
                                    class="h-full w-full object-cover">
                            @else
                                <span
                                    class="text-indigo-600 dark:text-indigo-400 font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400 transform transition-transform duration-200"
                            :class="{ 'rotate-180': userDropdownOpen }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="userDropdownOpen" x-cloak @click.away="userDropdownOpen = false" x-transition
                        class="absolute rtl:left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-right px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    {{-- قائمة الجوال – تشمل كل الروابط + التصنيفات --}}
    <div x-show="menuOpen" x-cloak x-transition
        class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="flex flex-col space-y-1 p-3 text-sm">
            <a href="{{ route('home') }}"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                🏠 <span>الرئيسية</span>
            </a>
            {{-- التصنيفات --}}
            <div x-data="{ openMobileCategories: false }">
                <button @click="openMobileCategories = !openMobileCategories"
                    class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-2">
                        📂 <span>الاقسام</span>
                    </div>
                    <svg x-bind:class="{ 'rotate-180': openMobileCategories }" class="w-4 h-4 transition-transform"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="openMobileCategories" x-cloak x-transition class="pl-6 mt-1">
                    @foreach ($categories as $category)
                        <a href="{{ route('posts.byCategory', $category->slug) }}"
                            class="block px-3 py-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                            - {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('about') }}"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                ℹ️ <span>حول الموقع</span>
            </a>
            <a href="{{ route('terms') }}"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                📜 <span>سياسة الاستخدام</span>
            </a>
            <a href="{{ route('contact') }}"
                class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                ✉️ <span>تواصل معنا</span>
            </a>
            @auth
                <a href="{{ route('posts.my') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700" title="مقالاتي">

                    <!-- أيقونة المقالات -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M12 4h9M4 9h16M4 15h16" />
                    </svg>

                    <span>مقالاتي</span>
                </a>
            @endauth



            {{-- البحث --}}
            <form action="{{ route('posts.search') }}" method="GET" class="relative px-3 pt-2">
                <input name="q" type="text" placeholder="ابحث..."
                    class="w-full px-3 py-2 rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" />
                <button type="submit" class="absolute left-5 top-3 text-gray-500 dark:text-gray-400">
                    🔍
                </button>
            </form>
        </div>
    </div>
