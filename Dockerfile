FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libssl-dev

COPY . /var/www/html
