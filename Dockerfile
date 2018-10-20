FROM php:7-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER="1"

COPY . /correios-php
WORKDIR /correios-php
RUN composer install

CMD ["composer", "test"]
