# A2C Manager

![A2C logo](http://www.a2c.com.br/assinatura_2014/images/logo_assinatura.jpg)

Este Readme é um passo a passo de como instalar o A2C Manager na sua maquina

## Vagrant

Acessar VM via SSH
	
	vagrant ssh	

Configuração padrão do parameters.yml
	
	parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: a2c_manager
    database_user: root
    database_password: root
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt

Criando o database
	
	php app/console doctrine:database:create

Criando as tabelas no banco de dados
	
	php app/console doctrine:schema:update --force

Executando fixtures para inserir dados no banco

	php app/console doctrine:fixtures:load

Usando RSYNC no windows
	
	Baixar e instalar: http://sourceforge.net/projects/rsyncforwindows/?source=typ_redirect

	Copiar caminho da pasta bin e inserir em variáveis de ambiente. 
	Ex: C:\Program Files (x86)\RsyncForWindows\bin

## Virtual Host Apache
    sudo nano /etc/apache2/sites-available/a2c_manager.conf

Adicionar as linhas abaixo no arquivo criado

	<VirtualHost *:80>
	    ServerName a2c_manager.dev
	
	    SetEnv APP_ENV 'dev'
	
	    DocumentRoot /var/www/web
	    <Directory /var/www/web>
	        AllowOverride All
	        Order Allow,Deny
	        Allow from All
	
	        <IfModule mod_rewrite.c>
	            Options -MultiViews
	            RewriteEngine On
	            RewriteCond %{REQUEST_FILENAME} !-f
	            RewriteRule ^(.*)$ app.php [QSA,L]
	        </IfModule>
	    </Directory>
	
	    # uncomment the following lines if you install assets as symlinks
	    # or run into problems when compiling LESS/Sass/CoffeScript assets
	    # <Directory /var/www>
	    #     Options FollowSymlinks
	    # </Directory>
	
	    ErrorLog /var/log/apache2/a2c_manager_error.log
	    CustomLog /var/log/apache2/a2c_manager_access.log combined
	</VirtualHost>
	
Depois de criar o arquivo é necessario habilitar o ele para isso devemos executar o seguinte comando no terminal

    sudo a2ensite a2c_manager.conf
    sudo service apache2 restart

## Adicionando o projeto no hosts
Adicionar a seguinte linha no **hosts**

	192.168.50.123 a2c_manager.dev 
   
## Padrões de desenvolvimento
 - Gulp
 - Boas praticas
