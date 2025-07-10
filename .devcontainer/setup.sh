#!/bin/bash
set -e

# التحديث وتثبيت أدوات أساسية
apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# تثبيت امتدادات PHP المطلوبة
docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath

# تثبيت Composer
cd /tmp
curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# العودة إلى دليل المستخدم
cd /home/www-data

# نقل المستخدم الحالي إلى الدليل الصحيح
cd /var/www/html

# تثبيت الاعتماديات
composer install

# إعداد ملف .env
cp .env.example .env

# توليد المفتاح
php artisan key:generate

# تشغيل المهاجرات
php artisan migrate --seed

# تشغيل السيرفر
php artisan serve --host 0.0.0.0