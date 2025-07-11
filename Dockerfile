FROM php:8.2-apache

# تثبيت الامتدادات المطلوبة
RUN apt-get update && apt-get install -y \
    libzip-dev unzip zip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# نسخ ملفات Laravel للمجلد الأساسي
COPY . /var/www/html

# إعداد Apache للـ Laravel
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# إعداد وثائق Laravel للعمل في public
WORKDIR /var/www/html
