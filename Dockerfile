FROM php:7-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER="1"

RUN mkdir /correios-php
WORKDIR /correios-php

COPY composer.json /correios-php
RUN composer install

COPY . /correios-php

CMD ["composer", "test"]
