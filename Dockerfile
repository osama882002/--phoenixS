# ✅ المرحلة الأولى: Node.js لبناء Vite
FROM node:18 as vite-builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# ✅ المرحلة الثانية: PHP + Apache
FROM php:8.2-apache

# إعدادات Laravel
WORKDIR /var/www/html

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تثبيت الإضافات
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip \
    && a2enmod rewrite

# نسخ ملفات المشروع
COPY . .

# ✅ نسخ ملفات Vite المبنية من المرحلة الأولى
COPY --from=vite-builder /app/public/build ./public/build

# صلاحيات Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# تثبيت Composer
RUN composer install --no-dev --optimize-autoloader

# توليد APP_KEY (لو مش موجود)
RUN cp .env.example .env && php artisan key:generate

# إعداد Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

EXPOSE 80
CMD ["apache2-foreground"]
