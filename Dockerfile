# ✅ استخدم PHP 8.2 مع Apache
FROM php:8.2-apache

# ✅ تثبيت Node.js وضروريات Laravel
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

# ✅ صلاحيات مجلدات التخزين
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# ✅ تثبيت Laravel و Vite (للإنتاج)
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# ✅ إعداد .env وتوليد مفتاح
RUN cp .env.example .env && \
    php artisan config:clear && \
    php artisan key:generate

# ✅ ضبط مجلد public في Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ✅ فتح المنفذ
EXPOSE 80

# ✅ بدء Apache
CMD ["apache2-foreground"]
