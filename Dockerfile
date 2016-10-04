FROM php:5.6-apache
RUN apt-get update && apt-get upgrade -y \
	php5-mysql \
	php5-xdebug \
	esmtp \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng12-dev

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) mysql pdo_mysql gd
RUN a2enmod rewrite && a2enmod headers && service apache2 restart
RUN ln -s /usr/bin/esmtp /usr/bin/sendmail
