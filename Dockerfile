# 1. Gunakan PHP 8.1 dengan Apache (sesuai standar CI4 saat ini)
FROM php:8.1-apache

# 2. Install Ekstensi PHP yang Wajib untuk CI4 (Intl, ICU, Mysql)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    zip \
    git \
    && docker-php-ext-install intl pdo pdo_mysql \
    && a2enmod rewrite

# 3. Ubah Document Root Apache ke folder /public (PENTING BUAT CI4!)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copy semua file project ke dalam container
WORKDIR /var/www/html
COPY . .

# 6. Jalankan Composer Install (agar vendor terinstall otomatis)
RUN composer install --no-dev --optimize-autoloader

# 7. Berikan hak akses ke folder writable (agar CI4 bisa nulis cache/log)
RUN chown -R www-data:www-data /var/www/html/writable
RUN chmod -R 777 /var/www/html/writable

# 8. Expose port (Heroku akan mengatur ini otomatis nanti, tapi standar 80)
EXPOSE 80