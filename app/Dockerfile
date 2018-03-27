FROM php:7.1-fpm

RUN apt-get update -y && apt-get install -y openssl zip unzip git wget libxml2 libxml2-dev nano zlib1g-dev \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng12-dev
RUN docker-php-ext-install pdo mbstring pdo_mysql mysqli soap zip

ADD php.ini /etc/php/7.0/cli/

COPY ./ /var/www
WORKDIR /var/www

CMD ["php-fpm"]
