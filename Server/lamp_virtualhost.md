Virtual host on LAMP

This tutorial describes how to setup a virtual host like http://localhost/your_project to http://your_project.loc
1. With the following step you should just check if the following code is correctly in the settings file. No need to recheck, this should be done only once:

  $ cd /etc/apache2/apache2.conf

Within this file should be included the following line:

   Include /etc/apache2/sites-enabled/

where the path should link to your site-enabled folder. If you are using another path, change it to yours.
2. After that, go to:

  $ cd /etc/apache2/sites-available/
3. Open a new file with the command:

  $ sudo gedit myproject.loc
4. Add the following lines to it:
<VirtualHost dev.example.com>

    ServerAdmin webmaster@localhost

    ServerAlias www.myproject.loc

    DocumentRoot /home/www_path_to_project/myproject

    CustomLog /home/www_path_to_project/myproject/error.log combined

</VirtualHost>


5. Go a level higher and enter the sites-enabled folder like that:

  $ cd /etc/apache2/sites-enabled/
6. Make a link between the myproject.loc and a shortcut into the actual directory:

  $ sudo ln -s /etc/apache2/sites-available/myproject.loc myproject.loc
7. Now if you will call http://myproject.loc, the browser will look on the internet for that web page. To avoid that and guide the browser to our local server add the following code to the host file:

  $sudo gedit /etc/hosts
  Add:

  127.0.0.1 localhost.localdomain localhost myproject.loc www.myproject.loc
8. To make work all this, restart apache with following command:

  $ sudo /etc/init.d/apache2 reload
Open in the browser http://myproject.loc and you should see your localhost project. If not, within the apache error.log you should look for the latest messages and to work on them.
Don't forget that the usual http://locahost/phpmyadmin will be no longer available and you have to make a similar localhost for it that will call the files of the previous URL.