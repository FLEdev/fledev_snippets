Install APACHE PHP and MySql (Lamp) on Linux Mint / Ubuntu / Debian

Predisposition for this is to have an actual list of repositories. To do so enter into the terminal:
  $ sudo apt-get update
1. Install Apache while entering  into Terminal:

  $ sudo apt-get install apache2



2. Check the proper working while entering into the Web browser: http://localhost/. You should find a standard page on that URL.



3. Install PHP while entering  into Terminal:

  $ sudo apt-get install php5

  $ sudo apt-get install libapache2-mod-php5

  $ sudo apt-get install php5-dev


4. After which restart apache with the following command:

  $ sudo /etc/init.d/apache2 restart
5. Check if the apache + php is working correctly, go to:

  cd /var/www/
Open the test.php with the following command:
  $ sudo gedit test.php

Write the following code into the document. Don't forget to save it.

  <?php phpinfo(); ?>



At the following address you should see all packages that are installed within PHP and Apache

http://localhost/test.php



6. Install MySQL with following command:

  $ sudo apt-get install libapache2-mod-auth-mysql
and make it work with php:

  $ sudo apt-get install php5-mysql

  $ sudo apt-get install mysql-server

  $ apt-get install curl libcurl3 php5-curl


7. Install PhpMyAdmin for database management:

  $ sudo apt-get install phpmyadmin
8. Many CMS systems and Web applications require the clean - speaking url (rewrite module) to be enabled. To enable enter the following command:

  $ sudo a2enmod rewrite

  $ apache2ctl -M


- To make sure all new software will work correctly, just reboot apache with the command:

  $ sudo /etc/init.d/apache2 reload
Memcache installation:
https://www.digitalocean.com/community/articles/how-to-install-and-use-m...
Now you should be able to work with PHP, MySQL within the modrewrite mode. To add a virtual host within your localhost, follow the next tutorial where I will explain how to add a virtual host on LAMP.