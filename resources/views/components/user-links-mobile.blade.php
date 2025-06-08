{{-- resources/views/components/user-links-mobile.blade.php --}}

@auth
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-indigo-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                @if(auth()->user()->profile_photo_path)
                    <img src="{{ auth()->user()->profile_photo_path }}" alt="صورة المستخدم" class="h-full w-full object-cover">
                @else
                    <span class="text-indigo-600 dark:text-indigo-400 font-medium text-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                @endif
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
            </div>
        </div>
        
        @if(auth()->user()->hasAnyRole(['admin', 'super-admin']))
            <a href="{{ route('admin.dashboard') }}" 
               class="text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-indigo-800 dark:text-indigo-300 font-semibold' : 'text-indigo-600 dark:text-indigo-400' }} hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors"
               title="لوحة التحكم">
                لوحة التحكم
            </a>
        @endif
    </div>
    
    <div class="border-t border-gray-200 dark:border-gray-700 mt-3 pt-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="block w-full text-right px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <span class="flex items-center gap-2 justify-end">
                    تسجيل الخروج
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
            </button>
        </form>
    </div>
@else
    <div class="grid grid-cols-2 gap-4 px-4 py-3">
        <a href="{{ route('login') }}"
           class="text-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium {{ request()->routeIs('login') ? 'bg-gray-100 dark:bg-gray-700 text-indigo-600 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-300' }} hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            دخول
        </a>
        <a href="{{ route('register') }}"
           class="text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md text-sm font-medium text-white transition-colors">
            حساب جديد
        </a>
    </div>
@endauth