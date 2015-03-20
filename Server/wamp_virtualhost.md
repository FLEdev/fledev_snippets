VirtualHost on WAMP & XAMPP

This short tutorial explains how to set a virtual host on a Windows machine within XAMPP.
The idea behind this is to work with your local projects in a similar manner as they would run on a web interface. After setting everything correctly you should be able to use instead of http://localhost/my_project the url: http://my_project.loc on your local project.


The # sign is used to ignore the line following it. This tutorial was made on basis of a Windows XP OS.

1. In c:/WINDOWS/system32/drivers/etc/hosts add:

127.0.0.1  myproject.loc
2. XAMMP:
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
# In c:/xampp/apache/conf/extra/httpd-vhosts.conf add:
NameVirtualHost myproject.loc:80
<VirtualHost myproject.loc:80>
  DocumentRoot C:/xampp/htdocs/myproject.loc/
  Options Indexes FollowSymLinks Includes ExecCGI
  #AllowOverride All
  #Order allow,deny
  #Allow from all
</VirtualHost>

# In c:/xampp/apache/conf/httpd.conf add:
Alias /myproject/ "/xampp/htdocs/myproject.loc/"
<Directory "/xampp/htdocs/myproject.loc/">
  AllowOverride None
  Options None
  Order allow,deny
  Allow from all
</Directory>

# Only check if in c:/xampp/apache/conf/httpd.conf the following lines are there:
DocumentRoot "/xampp/htdocs"
<Directory />
  Options FollowSymLinks
  AllowOverride All
  Order deny,allow
  Deny from all
</Directory>

<Directory "/xampp/htdocs">
  Options Indexes FollowSymLinks Includes ExecCGI
  AllowOverride All
  Order allow,deny
  Allow from all
</Directory>
2. WAMP:
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
# Make sure that in C:\wamp\bin\apache\Apache2.4.4\conf\httpd.conf at the end:
Include "c:/wamp/vhosts/*"
Include "c:/wamp/alias/*"

# in wamp/alias: add your_project.loc file with the content:
Alias /your_project.loc "c:/www/your_project"
<Directory c:/www/your_project>
   RewriteEngine on
   RewriteBase /
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php?q=$1 [L,QSA]
</Directory>

# In wamp/vhosts add your_project.loc file with the content:
NameVirtualHost your_project.loc:80
<VirtualHost your_project.loc:80>
  DocumentRoot c:/www/your_project
  Options Indexes FollowSymLinks Includes ExecCGI
  ErrorLog C:\wamp\logs\your_projectLoc_error.log
  TransferLog C:\wamp\logs\your_projectLoc_access.log
</VirtualHost>

# Or only in Alias folder:

NameVirtualHost project.loc
<VirtualHost project.loc>
    ServerName localhost
    DocumentRoot "C:/www/project/"
</VirtualHost>

<Directory "c:/www/project/">
    Options Indexes FollowSymLinks MultiViews
    AllowOverride all
    Order Deny,Allow
    Deny from all
    Allow from 127.0.0.1
</Directory>

3. Restart your apache from your XAMPP console and make sure that the server is started and running. Otherwise look into the log for errors usually in c:/xampp/apache/logs/error.log
4. If at http://myproject.loc your browser will display your site, you done it. Don't forget to check if your PHPmyAdmin is working properly or set it a separate virtual host.