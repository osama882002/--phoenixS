{{-- resources/views/site/terms.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 py-6 md:py-10">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-lg shadow-md dark:shadow-gray-700">
        <h1 class="text-2xl sm:text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-3 sm:mb-4">
            سياسة الاستخدام
        </h1>

        <p class="text-gray-700 dark:text-gray-200 leading-relaxed text-sm sm:text-base mb-4 sm:mb-6">
            باستخدامك لموقع <strong class="font-semibold">Phoenix Soul</strong>، فإنك توافق على الالتزام بالشروط والأحكام التالية:
        </p>

        <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 space-y-2 sm:space-y-3 mb-4 sm:mb-6 pl-4">
            <li class="text-sm sm:text-base">يُمنع نشر أي محتوى مسيء أو يحرض على العنف أو الكراهية أو يحتوي على معلومات مضللة.</li>
            <li class="text-sm sm:text-base">يحتفظ فريق الموقع بالحق في مراجعة أو رفض أو حذف أي مقال لا يتوافق مع سياسة المحتوى.</li>
            <li class="text-sm sm:text-base">المحتوى المنشور يعبر عن رأي كاتبه ولا يعكس بالضرورة توجه إدارة الموقع.</li>
            <li class="text-sm sm:text-base">يُمنع استخدام المنصة لأغراض تجارية أو ترويجية بدون إذن مسبق.</li>
            <li class="text-sm sm:text-base">جميع الحقوق محفوظة لأصحاب المقالات، ويُمنع نسخ أو إعادة استخدام المحتوى بدون إذن كتابي.</li>
        </ul>

        <p class="text-gray-700 dark:text-gray-300 text-sm sm:text-base">
            في حال وجود مخالفة أو شكوى، يرجى التواصل معنا عبر البريد الإلكتروني الرسمي الظاهر في صفحة التواصل.
        </p>
    </div>
</div>
@endsection