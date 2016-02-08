FROM eminetto/apache

LABEL Description = "This image is used to start Symfony2 project"

# Install Composer
#RUN cd /var/www/html
#RUN curl -sS https://getcomposer.org/installer | php

# Create the php.ini file
# RUN cp /usr/src/php/php.ini-development /usr/local/etc/php/php.ini
RUN usermod -u 1000 www-data