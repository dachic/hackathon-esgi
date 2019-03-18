FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libicu-dev libpq-dev && apt-get clean
RUN pecl install apcu xdebug
RUN docker-php-ext-enable apcu xdebug
RUN docker-php-ext-install intl opcache \
 && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
 && docker-php-ext-install pdo pdo_pgsql pgsql


WORKDIR /usr/share/nginx/html
