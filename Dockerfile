FROM eboraas/laravel 
MAINTAINER  Miguel Angel Gordian <miguel.angel@kaltia.org>

RUN apt-get -y install php5-mysql wget

COPY . /var/www/laravel/
COPY docker/00* /etc/apache2/sites-enabled/

WORKDIR /var/www/laravel

RUN composer install && \
    chown -R www-data:www-data bootstrap storage && \
    ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log

