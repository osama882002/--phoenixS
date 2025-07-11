# ✅ استخدم PHP 8.2 مع Apache و Node.js في نفس الحاوية
FROM php:8.2-apache

# ✅ تثبيت Node.js (مطلوب لـ Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && apt-get install -y nodejs git unzip zip curl libzip-dev libonig-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring zip && \
    a2enmod rewrite

# ✅ تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ✅ تعيين مجلد العمل
WORKDIR /var/www/html

# ✅ نسخ كل المشروع
COPY . .

# ✅ تثبيت Laravel + Vite
RUN composer install --no-dev --optimize-autoloader && \
    npm install && \
    npm run build

# ✅ إعداد Laravel
RUN cp .env.example .env && php artisan key:generate

# ✅ ضبط Apache ليستخدم public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]
