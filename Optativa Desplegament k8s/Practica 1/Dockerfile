FROM php:8.1-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN sed -i 's/^Listen 80$/Listen 8888/' /etc/apache2/ports.conf \
 && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8888>/' /etc/apache2/sites-available/000-default.conf

COPY index.php /var/www/html/

EXPOSE 8888
