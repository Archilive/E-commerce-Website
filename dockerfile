FROM php:8.0-apache

RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

EXPOSE 80