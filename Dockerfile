FROM php:7.0-apache

ADD . /var/www/html

RUN apt update
RUN apt upgrade -y
RUN apt install -y apt-utils
RUN a2enmod rewrite
RUN apt install -y git unzip
RUN apt install -y libmcrypt-dev
RUN docker-php-ext-install mcrypt
RUN apt install -y libicu-dev
RUN docker-php-ext-install -j$(nproc) intl
RUN apt install -y libxml2-dev 
RUN apt install -y libldb-dev
RUN apt install -y libldap2-dev 
RUN apt install -y libxml2-dev
RUN apt install -y libssl-dev
RUN apt install -y libxslt-dev
RUN apt install -y libpq-dev
RUN apt install -y mysql-client 
RUN apt install -y mariadb-client 
RUN apt install -y curl
RUN apt install -y libcurl3
RUN docker-php-ext-install pdo
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install pgsql
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install intl
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-install mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer