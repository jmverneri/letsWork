FROM php:8.2-apache
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN docker-php-ext-install pdo pdo_mysql && a2enmod rewrite
COPY . /var/www/html/
RUN composer install --no-dev --optimize-autoloader
EXPOSE 80