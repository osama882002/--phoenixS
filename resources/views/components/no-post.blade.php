{{-- resources/views/components/no-post.blade.php --}}
<div class="col-span-full text-center py-12 px-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
    <div class="max-w-md mx-auto space-y-6">
        {{-- أيقونة توضيحية --}}
        <div class="text-5xl text-gray-400 dark:text-gray-500">
            📭
        </div>
        
        {{-- الرسالة الرئيسية --}}
        <h3 class="text-xl font-medium text-gray-700 dark:text-gray-300">
            لا توجد مقالات متاحة حالياً
        </h3>
        
        {{-- الرسالة الثانوية --}}
        <p class="text-gray-500 dark:text-gray-400">
            @if(isset($customMessage))
                {{ $customMessage }}
            @else
                كن أول من يشارك مقالة جديدة وأثرِ المحتوى العربي
            @endif
        </p>
        
        {{-- زر الإضافة --}}
        <div class="pt-4">
            <a href="{{ route('posts.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 text-white px-6 py-3 rounded-full text-sm font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg">
                <span class="text-lg">➕</span>
                <span>إضافة مقال جديد</span>
            </a>
        </div>
        
        {{-- رسالة تشجيعية إضافية --}}
        <p class="text-xs text-gray-400 dark:text-gray-500 pt-4">
            مشاركتك تساعد في إثراء المحتوى العربي وتقديم قيمة للقراء
        </p>
    </div>
</div>