FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y build-essential xorg libssl-dev libxrender-dev wget gdebi libyaml-dev

RUN docker-php-ext-install pdo_mysql
RUN pecl install apcu-5.1.8 xdebug
RUN pecl install yaml
RUN docker-php-ext-enable apcu yaml

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && mv composer /usr/local/bin/composer

WORKDIR /usr/src/app

#COPY ./ /usr/src/app

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "xdebug.remote_port = 9000" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin