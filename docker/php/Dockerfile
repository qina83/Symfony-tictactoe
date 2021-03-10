FROM php:7.4-fpm

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        libpng-dev \
        zlib1g-dev

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
