# ✅ استخدم PHP 8.2 مع Apache
FROM php:8.2-apache

# ✅ تثبيت Node.js (مطلوب لـ Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && apt-get install -y \
    nodejs \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && a2enmod rewrite

# ✅ تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ✅ تعيين مجلد العمل
WORKDIR /var/www/html

# ✅ نسخ جميع ملفات المشروع
COPY . .

# ✅ إعطاء صلاحيات للمجلدات المطلوبة (storage + cache)
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# ✅ تثبيت حزم Laravel + Vite
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# ✅ إعداد .env وتوليد مفتاح التطبيق
RUN cp .env.example .env && php artisan key:generate

# ✅ تعيين مجلد public كجذر الموقع في Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# ✅ تحديث إعدادات Apache ليستخدم public/
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ✅ فتح المنفذ 80
EXPOSE 80

# ✅ بدء تشغيل Apache
CMD ["apache2-foreground"]
