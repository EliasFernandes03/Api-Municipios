FROM php:8.3-apache

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    zip \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini


RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
