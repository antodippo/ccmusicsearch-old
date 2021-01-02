FROM php:7.4-apache

COPY . /var/www/ccmusicsearch
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN pecl channel-update pecl.php.net
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN apt-get update
RUN apt-get install -y libzip-dev zip \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN chown -R www-data:www-data /var/www/ccmusicsearch
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart

COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_CACHE_DIR=/root/.composer/cache
