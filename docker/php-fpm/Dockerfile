FROM php:8.2.8-fpm-alpine3.18

RUN apk add --no-cache --virtual .build-deps autoconf build-base libpq-dev oniguruma-dev linux-headers rabbitmq-c-dev sqlite-dev icu-dev

RUN printf "\n" | pecl install amqp \
    && pecl install redis \
    && docker-php-ext-enable amqp redis \
    && docker-php-ext-install opcache \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pdo_sqlite \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_CACHE_DIR /dev/null

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && curl -sS https://composer.github.io/installer.sig -o installer.sig \
    && php -r "exit((int)(hash_file('SHA384', 'composer-setup.php') !== '$(cat installer.sig)'));" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php installer.sig

RUN addgroup -g 1000 php-user \
    && adduser -u 1000 -S php-user -G php-user \
    && mkdir /app \
    && chown -R php-user:php-user /app

USER php-user

WORKDIR /app