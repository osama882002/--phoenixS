@props(['active' => 'dashboard'])

{{-- التصميم المرن حسب الشاشة --}}
<nav class="bg-white dark:bg-gray-900 shadow-md">
    {{-- الشاشات الصغيرة: أفقي --}}
    <div class="flex md:hidden overflow-x-auto border-b dark:border-gray-700">
        <ul class="flex w-full text-sm text-gray-700 dark:text-gray-300 whitespace-nowrap">
            <li class="flex-1 text-center py-3 px-2 {{ $active == 'dashboard' ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 dark:border-indigo-400' : 'hover:text-indigo-600' }}">
                <a href="{{ route('admin.dashboard') }}">🏠 الرئيسية</a>
            </li>
            <li class="flex-1 text-center py-3 px-2 {{ $active == 'review' ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 dark:border-indigo-400' : 'hover:text-indigo-600' }}">
                <a href="{{ route('admin.posts.review') }}">📝 مراجعة المقالات</a>
            </li>
            <li class="flex-1 text-center py-3 px-2 {{ $active == 'users' ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 dark:border-indigo-400' : 'hover:text-indigo-600' }}">
                <a href="{{ route('admin.users.index') }}">👥 المستخدمين</a>
            </li>
            <li class="flex-1 text-center py-3 px-2 {{ $active == 'posts' ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 dark:border-indigo-400' : 'hover:text-indigo-600' }}">
                <a href="{{ route('admin.posts.index') }}">📚 جميع المقالات</a>
            </li>
            <li class="flex-1 text-center py-3 px-2 {{ $active == 'notifications' ? 'text-indigo-600 font-bold border-b-2 border-indigo-600 dark:border-indigo-400' : 'hover:text-indigo-600' }}">
                <a href="{{ route('admin.notifications') }}">🔔 الإشعارات</a>
            </li>
        </ul>
    </div>

    {{-- الشاشات الكبيرة: عمودي --}}
    <aside class="hidden md:block w-64 min-h-screen border-r dark:border-gray-700">
        <div class="p-6 text-indigo-700 dark:text-indigo-300 text-xl font-bold border-b dark:border-gray-700">
            لوحة التحكم
        </div>
        <ul class="px-4 py-6 space-y-4 text-gray-700 dark:text-gray-300 text-sm">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ $active == 'dashboard' ? 'text-indigo-600 font-bold' : 'hover:text-indigo-600' }}">
                    🏠 الرئيسية
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.review') }}"
                    class="{{ $active == 'review' ? 'text-indigo-600 font-bold' : 'hover:text-indigo-600' }}">
                    📝 مراجعة المقالات
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ $active == 'users' ? 'text-indigo-600 font-bold' : 'hover:text-indigo-600' }}">
                    👥 المستخدمين
                </a>
            </li>
            <li>
                <a href="{{ route('admin.posts.index') }}"
                    class="{{ $active == 'posts' ? 'text-indigo-600 font-bold' : 'hover:text-indigo-600' }}">
                    📚 جميع المقالات
                </a>
            </li>
            <li>
                <a href="{{ route('admin.notifications') }}"
                    class="{{ $active == 'notifications' ? 'text-indigo-600 font-bold' : 'hover:text-indigo-600' }}">
                    🔔 الإشعارات
                </a>
            </li>
        </ul>
    </aside>
</nav>
