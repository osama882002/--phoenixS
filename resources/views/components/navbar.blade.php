<nav x-data="{ isOpen: false, searchOpen: false }"
    class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm shadow-sm sticky top-0 z-40 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- الجزء الأيسر (الشعار وزر القائمة) -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- زر القائمة المتنقلة -->
                <button @click="isOpen = !isOpen" aria-label="قائمة التنقل"
                    class="md:hidden p-2 rounded-md text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                    <svg x-show="!isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="isOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- الشعار -->
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center focus:outline-none group">
                    <img src="{{ asset('phoenix_logo.png') }}" alt="Phoenix Soul Logo" class="h-8 w-8 mr-2 ml-2 transition-transform group-hover:scale-105">
                    <span class="hidden md:block text-xl font-bold text-indigo-700 dark:text-indigo-300 whitespace-nowrap transition-colors">
                        Phoenix Soul
                    </span>
                </a>
            </div>

            <!-- الجزء الأوسط (القائمة الرئيسية) -->
            <div class="hidden md:flex md:items-center md:space-x-6 rtl:space-x-reverse">
                @include('components.nav_links')
            </div>

            <!-- الجزء الأيمن (بحث وإعدادات) -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <!-- شريط البحث (إصدار سطح المكتب) -->
                <div class="hidden md:block relative">
                    <form action="{{ route('posts.search') }}" method="GET">
                        <input type="text" name="q" placeholder="ابحث..."
                            class="pr-10 pl-4 py-2 rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-48 sm:w-56 transition-all duration-200"
                            aria-label="بحث">
                        <button type="submit" class="absolute left-3 top-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- زر البحث (إصدار الجوال) -->
                <button @click="searchOpen = !searchOpen" class="md:hidden p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500" aria-label="بحث">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <!-- زر الوضع الداكن -->
                <button @click="toggleDark" aria-label="تبديل الوضع الداكن"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span x-show="!dark" x-cloak class="text-gray-700 dark:text-gray-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                    <span x-show="dark" x-cloak class="text-gray-700 dark:text-gray-200">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                </button>

                <!-- روابط المستخدم -->
                @include('components.user-links')
            </div>
        </div>

        <!-- شريط البحث للجوال -->
        <div x-show="searchOpen" x-transition.opacity class="md:hidden px-2 py-3">
            <form action="{{ route('posts.search') }}" method="GET" class="relative">
                <input type="text" name="q" placeholder="ابحث عن مقال..."
                    class="block w-full px-4 py-2 pr-10 rounded-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                    aria-label="بحث">
                <button type="submit" class="absolute left-3 top-2 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- القائمة المتنقلة -->
        <div x-show="isOpen" x-transition.opacity class="md:hidden bg-white dark:bg-gray-800 shadow-xl transition-all duration-300">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @include('components.nav_links')
            </div>

            <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                @include('components.user-links-mobile')
            </div>
        </div>
    </div>
</nav>