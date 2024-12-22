FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libssl1.1 \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

EXPOSE 80
CMD ["apache2-foreground"]
