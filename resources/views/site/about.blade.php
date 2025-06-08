{{-- resources/views/site/about.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-6 md:py-10">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow-md dark:shadow-gray-700">
        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-3 sm:mb-4">
            حول موقع Phoenix Soul
        </h1>
        
        <p class="text-gray-700 dark:text-gray-200 leading-relaxed text-sm sm:text-base mb-4 sm:mb-6">
            Phoenix Soul هي مدونة مجتمعية تهدف إلى تمكين الأفراد من التعبير عن قصصهم وتجاربهم في ظل الظروف الإنسانية الصعبة.
            نقدم مساحة آمنة وملهمة لمشاركة:
        </p>
        
        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-1 sm:space-y-2 mb-4 sm:mb-6 pl-4">
            <li class="text-sm sm:text-base">الوصفات التقليدية في أوقات الأزمات.</li>
            <li class="text-sm sm:text-base">قصص الصمود والإبداع في وجه النزوح والصراع.</li>
            <li class="text-sm sm:text-base">نصائح صحية ومجتمعية عملية.</li>
            <li class="text-sm sm:text-base">توثيق الذكريات التي لا يجب أن تُنسى.</li>
            <li class="text-sm sm:text-base">نصائح للسلامة أثناء التغيرات الجوية.</li>
        </ul>
        
        <p class="text-gray-700 dark:text-gray-200 text-sm sm:text-base mb-3 sm:mb-4">
            نحن نؤمن بأن مشاركة الكلمة والصورة والتجربة يمكن أن تخلق تغييرًا. فريق Phoenix Soul يعمل على مراجعة المقالات المقدمة وضمان احترام المحتوى لجميع فئات المجتمع.
        </p>
        
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
            تم إطلاق الموقع في عام 2025 من أجل دعم وتمكين الصوت الإنساني في المناطق المتأثرة بالأزمات.
        </p>
    </div>
</div>
@endsection