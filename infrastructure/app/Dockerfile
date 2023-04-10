FROM php:8.2.3-fpm
ENV TZ ${TIMEZONE}
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt update -qq && \
    apt install --no-install-recommends -y \
        libonig-dev \
        libpq-dev \
        git \
        zip \
        unzip && \
    apt clean && \
    rm -rf /var/cache/apt

RUN docker-php-ext-install mbstring pdo pdo_pgsql

COPY ./infrastructure/app/php.ini /usr/local/etc/php/php.ini
COPY ./infrastructure/app/docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY ./infrastructure/app/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ../../. /app

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

WORKDIR /app

RUN /usr/local/bin/composer install -d /app
RUN chown www-data: -R ./
