FROM php:7.4-apache

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN rm /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql


COPY ./docker/build/apache/000-default.conf  /etc/apache2/sites-available/000-default.conf
COPY ./docker/wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

WORKDIR /var/www/html


COPY . /var/www/html/

