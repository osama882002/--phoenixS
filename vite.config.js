// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build', // ✅ هذا يحدد مكان الملفات المجمعة
        manifest: true,         // ✅ هذا يضمن توليد manifest.json
        rollupOptions: {
            input: ['resources/css/app.css', 'resources/js/app.js'],
        },
    },
});
