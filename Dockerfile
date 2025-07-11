# ✅ استخدم PHP مع Apache
FROM php:8.1-apache

# ✅ إعداد بيئة العمل
WORKDIR /var/www/html

# ✅ تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ✅ تثبيت الإضافات المطلوبة لـ Laravel
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# ✅ تفعيل mod_rewrite في Apache (مهم لـ Laravel routing)
RUN a2enmod rewrite

# ✅ نسخ ملفات المشروع إلى الحاوية
COPY . .

# ✅ إعطاء صلاحيات للمجلدات المطلوبة
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ✅ تثبيت الحزم عبر Composer
RUN composer install --no-dev --optimize-autoloader

# ✅ تحديد مجلد public كنقطة بداية
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# ✅ تعديل إعدادات Apache ليستخدم public كجذر
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ✅ كشف المنفذ 80
EXPOSE 80

# ✅ أمر التشغيل الأساسي
CMD ["apache2-foreground"]
