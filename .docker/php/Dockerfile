FROM php:8.1-fpm-alpine

RUN set -eux  \
    && apk update \
    && apk add  \
        $PHPIZE_DEPS \
        imagemagick \
        imagemagick-dev \
        libgomp \
        libjpeg-turbo-dev \
        libpng-dev \
        libpq-dev \
        libwebp \
        nginx \
        php81-opcache \
    && pecl install \
        imagick \
    && docker-php-ext-enable \
        imagick \
    && apk del \
        $PHPIZE_DEPS;

ARG PROJECT_ROOT
ARG PUBLIC_DIR
ENV PUBLIC_DIR $PUBLIC_DIR

COPY .docker/php/ini /usr/local/etc/php/conf.d

COPY --chown=www-data:www-data ../.. $PROJECT_ROOT

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

WORKDIR $PROJECT_ROOT

CMD ["php-fpm"]

EXPOSE 80
