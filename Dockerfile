FROM php:7.0.3-apache

RUN apt-get update && apt-get install -y vim libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev libicu-dev mlocate python pkg-config build-essential libmemcached-dev

RUN docker-php-ext-install iconv mcrypt mysqli
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install intl

RUN a2enmod rewrite && apachectl restart

RUN touch /etc/apache2/sites-available/000-default.conf

RUN a2ensite 000-default.conf && apachectl restart

RUN touch /usr/local/etc/php/conf.d/xdebug.ini; \
	echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/xdebug.ini; \
  	echo xdebug.remote_autostart=0 >> /usr/local/etc/php/conf.d/xdebug.ini; \
  	echo xdebug.remote_connect_back=1 >> /usr/local/etc/php/conf.d/xdebug.ini; \
  	echo xdebug.remote_port=9000 >> /usr/local/etc/php/conf.d/xdebug.ini; \
  	echo xdebug.remote_log=/tmp/php5-xdebug.log >> /usr/local/etc/php/conf.d/xdebug.ini;

RUN apt-get install -y git

RUN cd ~ && \
    git clone https://github.com/php-memcached-dev/php-memcached.git && \
    cd php-memcached && \
    git checkout php7 && \
    phpize && \
    ./configure --disable-memcached-sasl && \
    make && make test && make install && \
    echo "extension = /usr/local/lib/php/extensions/no-debug-non-zts-20151012/memcached.so" >> /usr/local/etc/php/php.ini && \
    apachectl graceful

RUN	mkdir ~/software && \
	cd  ~/software/ && \
	apt-get install -y wget && \
	wget http://xdebug.org/files/xdebug-2.4.0beta1.tgz && \
	tar -xvzf xdebug-2.4.0beta1.tgz && \
	cd xdebug-2.4.0beta1 && \
	phpize && \
	./configure && \
	make && \
	cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20151012 && \
	echo "zend_extension = /usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so" >>  /usr/local/etc/php/php.ini && \
	apachectl graceful

# npm install
RUN curl -sL https://deb.nodesource.com/setup | bash - && \
  apt-get install -y nodejs

RUN npm -g install npm@latest-2

# gulp install
RUN npm install -g gulp-cli

# bower install
RUN npm install -g bower

# Add user
RUN usermod -u 1000 www-data

# Install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

RUN curl -LsS http://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony

RUN rm -Rf ~/software
RUN rm -Rf ~/php-memcached

WORKDIR /var/www/html