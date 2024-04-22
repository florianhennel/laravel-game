FROM php:8.3.6-cli

RUN apt-get update -y && apt-get install -y openssl zip unzip git libsqlite3-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /laravel-game
COPY . /laravel-game
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8181

EXPOSE 8181