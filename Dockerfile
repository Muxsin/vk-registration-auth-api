FROM php:8.2-cli

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git curl unzip

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /opt/app
WORKDIR /opt/app

CMD php -S 0.0.0.0:80 -t public
