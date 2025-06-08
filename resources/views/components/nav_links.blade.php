<ul class="flex flex-row items-center space-x-6 rtl:space-x-reverse">
    <!-- الصفحة الرئيسية -->
    <li>
        <a href="{{ route('home') }}" 
           class="flex items-center {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400 font-medium border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1">
            الرئيسية
        </a>
    </li>

    {{-- قائمة الأقسام المنسدلة --}}
    <li x-data="{ open: false }" class="relative">
        <button @click="open = !open" 
                class="flex items-center {{ request()->routeIs('posts.byCategory') ? 'text-indigo-600 dark:text-indigo-400 font-medium' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1">
            الأقسام
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transform transition-transform duration-200" 
                 :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

        <ul x-show="open" x-cloak @click.away="open = false" x-transition
            class="absolute rtl:right-0 mt-2 w-48 bg-white dark:bg-gray-800 shadow-lg rounded-md z-50 py-1 border border-gray-200 dark:border-gray-700">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('posts.byCategory', $category->slug) }}"
                       class="block px-4 py-2 text-sm {{ request()->routeIs('posts.byCategory') && request('category') == $category->slug ? 'bg-indigo-50 dark:bg-gray-700 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700' }} transition-colors">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>

    {{-- حول الموقع --}}
    <li>
        <a href="{{ route('about') }}" 
           class="flex items-center {{ request()->routeIs('about') ? 'text-indigo-600 dark:text-indigo-400 font-medium border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1">
            حول الموقع
        </a>
    </li>

    {{-- سياسة الاستخدام --}}
    <li>
        <a href="{{ route('terms') }}" 
           class="flex items-center {{ request()->routeIs('terms') ? 'text-indigo-600 dark:text-indigo-400 font-medium border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1">
            سياسة الاستخدام
        </a>
    </li>

    @auth
        {{-- مقالاتي - تظهر للمستخدمين المسجلين فقط --}}
        <li>
            <a href="{{ route('posts.my') }}" 
               class="flex items-center {{ request()->routeIs('posts.my') ? 'text-indigo-600 dark:text-indigo-400 font-medium border-b-2 border-indigo-600 dark:border-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors pb-1">
                مقالاتي
            </a>
        </li>

        {{-- إضافة مقال - تظهر للمستخدمين المسجلين فقط
        <li>
            <a href="{{ route('posts.create') }}" 
               class="flex items-center bg-indigo-600 text-white px-3 py-1 rounded-md hover:bg-indigo-700 transition-colors ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                مقال جديد
            </a>
        </li> --}}
    @endauth
</ul>