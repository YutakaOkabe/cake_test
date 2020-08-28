FROM php:7.3-apache

RUN set -ex apk --no-cache add postgresql-dev libpq-dev && \
    apt-get update && apt-get install -y libpq-dev \
    libicu-dev \
    vim zip\
    less \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring intl

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /var/www/html/webroot

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf