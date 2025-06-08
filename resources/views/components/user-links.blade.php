{{-- resources/views/components/user-links.blade.php --}}


@auth
    <div class="flex items-center gap-4 rtl:gap-4">
        @if (auth()->user()->hasAnyRole(['admin', 'super-admin']))
            <a href="{{ route('admin.dashboard') }}"
                class="hidden md:flex items-center gap-1 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-indigo-800 dark:text-indigo-300 font-semibold' : 'text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300' }} transition-colors"
                title="لوحة التحكم">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                {{-- لوحة التحكم --}}
            </a>
        @endif

        @php
            $unreadNotificationsCount = auth()->user()->unreadNotifications->count();
            $route = auth()
                ->user()
                ->hasAnyRole(['admin', 'super-admin'])
                ? route('admin.notifications')
                : route('user.notifications');
        @endphp

        <a href="{{ $route }}"
            class="relative p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.notifications', 'user.notifications') ? 'bg-indigo-100 dark:bg-gray-700' : '' }}"
            title="الإشعارات">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 {{ request()->routeIs('admin.notifications', 'user.notifications') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300' }}"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>

            @if ($unreadNotificationsCount > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-5">
                    {{ $unreadNotificationsCount > 9 ? '9+' : $unreadNotificationsCount }}
                </span>
            @endif
        </a>

        <div x-data="{ open: false }"  class="relative">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group"
                aria-label="قائمة المستخدم">
                <span
                    class="hidden md:inline text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                    {{ auth()->user()->name }}
                </span>
                <div
                    class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 {{ request()->routeIs('profile.show') ? 'border-indigo-600 dark:border-indigo-400' : 'border-transparent group-hover:border-indigo-300 dark:group-hover:border-gray-500' }} transition-colors">
                    @if (auth()->user()->profile_photo_path)
                        <img src="{{ auth()->user()->profile_photo_path }}" alt="صورة المستخدم"
                            class="h-full w-full object-cover">
                    @else
                        <span class="text-indigo-600 dark:text-indigo-400 font-medium">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-gray-500 dark:text-gray-400 transform transition-transform duration-200"
                    :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <div x-show="open" x-cloak @click.away="open = false" x-transition
                class="absolute rtl:right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700">
                {{-- <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('profile.show') ? 'bg-gray-50 dark:bg-gray-700' : '' }}">
                    الملف الشخصي
                </a> --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-right px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <span class="flex items-center gap-2 justify-end">
                            تسجيل الخروج
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="flex items-center gap-4 rtl:gap-4">
        <a href="{{ route('login') }}"
            class="text-sm font-medium {{ request()->routeIs('login') ? 'text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400' }} transition-colors">
            دخول
        </a>
        <a href="{{ route('register') }}"
            class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-1.5 rounded-md transition-colors">
            حساب جديد
        </a>
    </div>
@endauth
