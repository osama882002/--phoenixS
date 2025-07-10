#!/bin/bash

echo "🔄 Starting Laravel project setup..."

# 1. تثبيت حزم composer
echo "📦 Installing PHP dependencies..."
composer install

# 2. إنشاء ملف .env
echo "📄 Copying .env.example to .env..."
cp .env.example .env

# 3. توليد APP_KEY
echo "🔑 Generating application key..."
php artisan key:generate

# 4. إعداد قاعدة البيانات (تذكير للمستخدم)
echo "⚠️ Please make sure to update your .env file with correct database settings."

# 5. تشغيل الـ Migrations
read -p "🧱 Do you want to run migrations now? (y/n): " runMigrations
if [[ "$runMigrations" == "y" ]]; then
    php artisan migrate
fi

# 6. تشغيل الـ Seeders (اختياري)
read -p "🌱 Do you want to seed the database? (y/n): " runSeeders
if [[ "$runSeeders" == "y" ]]; then
    php artisan db:seed
fi

# 7. تثبيت npm dependencies إذا وجدت
if [ -f "package.json" ]; then
    echo "📦 Installing npm packages..."
    npm install

    # تشغيل vite أو mix
    if grep -q "vite" package.json; then
        echo "🚀 Running Vite build..."
        npm run dev
    else
        echo "🚀 Running Laravel Mix build..."
        npm run dev
    fi
fi

# 8. تشغيل السيرفر
echo "✅ Setup complete. Starting Laravel server..."
php artisan serve

