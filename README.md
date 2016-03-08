[![Codacy Badge](https://api.codacy.com/project/badge/grade/0872e1d256f14bc2ba231ab9a91d5726)](https://www.codacy.com)
# Bacon Manager

This Readme is a step-by-step tutorial on how to use the A2C Manager on your project

## In case you use Linux

    Stop Apache/Httpd and Mysql services or change the used ports on docker-compose.yml. 
    Ex: ports:  81:80

## Docker

    Creating and initializing Docker containers
    docker-compose up -d

#### See created containers

    docker ps
    
    CONTAINER ID        IMAGE
    56a46e2f2ecf        baconmanager_web    ...     
    036483db7918        mysql               ...

#### Acessing Web Container

    docker exec -ti 56a46e2f2ecf /bin/bash

#### Installing dependencies

    composer install
    bower install
    gulp build

#### Default configuration of parameters.yml
    
    parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: bacon_manager
    database_user: bacon_manager
    database_password: 123
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt


#### Creating database tables
    
    php app/console doctrine:schema:update --force

#### Putting default data

    php app/console doctrine:fixtures:load

#### In case connection gets refused ( Linux )

    docker inspect 036483db7918 | grep IPAddress

    Get IP. Ex: "172.17.0.2"

    And change it on parameters.yml. 

    Ex: parameters:
        database_host: 172.17.0.2

## Virtual Host Apache
#### With the build command a virtual host is created in 
    
    /etc/apache2/sites-available/000-default.conf

#### Virtual Host is accessible to changes like ServerName and/or DocumentRoot

    <VirtualHost *:80>
        ServerName bacon_manager.dev
        DocumentRoot /var/www/html/web
        <Directory /var/www/html/web>
            Options Indexes FollowSymLinks
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    
##### After its creation, we have to enable it with the command that follows

    sudo a2ensite 000-default.conf
    sudo service apache2 restart

## Adding the Project on Hosts
#### Add this line on **hosts**

    127.0.0.1 a2c_manager.dev 
   
## Development Practices
 - Gulp
 - Good pratices

## Sponsored By

![A2C logo](http://www.a2c.com.br/)