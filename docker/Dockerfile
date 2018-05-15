FROM php:7.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y git zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer
RUN docker-php-ext-install pdo_mysql json
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /etc/php/7.2/apache2/php.ini
RUN a2enmod rewrite
EXPOSE 80

CMD apache2-foreground
