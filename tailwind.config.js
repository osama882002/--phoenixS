import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // تفعيل الوضع الداكن عبر إضافة الـ class "dark" إلى عنصر <html> أو الـ <body>
    darkMode: 'class',

    content: [
        // جميع ملفات Blade داخل resources/views
        './resources/views/**/*.blade.php',

        // ملفات JavaScript/TypeScript (بما في ذلك أيّ مكوّنات Vue أو React)
        './resources/js/**/*.js',
        './resources/js/**/*.jsx',
        './resources/js/**/*.ts',
        './resources/js/**/*.tsx',
        './resources/js/**/*.vue',

        // ملفات الـ PHP المؤقتة التي يولّدها Laravel أثناء العرض
        './storage/framework/views/*.php',

        // ملفات الـ Pagination الافتراضية في إطار Laravel
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                // إضافة خط Figtree قبل الخطوط الافتراضية
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // يمكنك إضافة تخصيصات لونية أو غيرها هنا إذا أردت
            // colors: {
            //   primary: '#1E40AF',
            //   secondary: '#9333EA',
            // },
        },
    },

    plugins: [
        forms,
        // إذا أردت استخدام الإضافات الرسمية الأخرى، فكّر بإضافة ما يلي:
        // require('@tailwindcss/typography'),
        // require('@tailwindcss/aspect-ratio'),
    ],
};
