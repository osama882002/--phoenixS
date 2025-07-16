# ✅ المرحلة الأولى: بناء الأصول باستخدام Node
FROM node:18 AS node-builder

WORKDIR /app

# نسخ ملفات المشروع فقط المتعلقة بالبناء
COPY package.json package-lock.json vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm install && npm run build

# --------------------------

# ✅ المرحلة الثانية: إعداد Laravel مع Apache + PHP
FROM php:8.2-apache

# تثبيت الحزم المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && a2enmod rewrite

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ كل ملفات المشروع
COPY . .

# نسخ ملفات build الجاهزة من المرحلة الأولى
COPY --from=node-builder /app/public/build ./public/build

# إعداد صلاحيات التخزين
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# تثبيت Laravel (بـ composer فقط)
RUN composer install --no-dev --optimize-autoloader

# إعداد .env والمفتاح
RUN cp .env.example .env && \
    php artisan config:clear && \
    php artisan key:generate

# ضبط Apache ليستخدم مجلد public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80

CMD ["apache2-foreground"]
