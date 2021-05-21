FROM php:7.3-fpm-alpine

WORKDIR /var/www

RUN apk update && apk add \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install Xdebug Extension
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-3.0.1 \
    && docker-php-ext-enable xdebug

# Get Composer 1.10.19
COPY --from=composer:1.10.19 /usr/bin/composer /usr/bin/composer

# Copy config
COPY ./.docker/app/local.ini /usr/local/etc/php/conf.d/local.ini

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

USER www

COPY --chown=www:www . /var/www

EXPOSE 9000
