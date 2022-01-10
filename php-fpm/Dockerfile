FROM php:7.4-fpm

#pdoインストール
RUN docker-php-ext-install pdo_mysql

#composerインストール
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

#gitインストール
RUN apt-get update
RUN apt-get install -y git

#unzipインストール
RUN apt-get install zip unzip