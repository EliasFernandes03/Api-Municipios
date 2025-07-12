FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y nginx zip unzip curl git && \
    docker-php-ext-install pdo pdo_mysql

COPY . /var/www

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN chown -R www-data:www-data /var/www

EXPOSE 80

CMD service nginx start && php-fpm
