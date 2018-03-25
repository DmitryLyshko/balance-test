FROM php:7.1-fpm

RUN apt-get update -y && apt-get install -y openssl zip unzip git wget libxml2 libxml2-dev nano zlib1g-dev \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng12-dev
RUN docker-php-ext-install pdo mbstring pdo_mysql mysqli soap zip

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Добавим свой php.ini, можем в нем определять свои значения конфига
#ADD php.ini /etc/php/7.0/cli/

WORKDIR /var/www

COPY ./composer.json /var/www/composer.json
COPY ./composer.lock /var/www/composer.lock
RUN composer install
COPY . /app/

CMD ["php-fpm"]
