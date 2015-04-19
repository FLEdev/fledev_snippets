To password prottect your web directory, follow these steps:
1. Within PHP and Apache make sure the following tho modules are enabled correctly:

  mod_authn_file.c

  .htaccess modrewrite
Check the path of your current working directory while making a new file or run the following php code from the directory (or the main root web application directory).
Into check.php add: <?php echo getcwd(); ?> . After loading the http://TheURL.com/check.php you should see the current working directory. This will be needed at the following step. Don't forget to remove the check.php file.
2. Create a .htaccess file or add to your existing one:

```
<IfModule mod_authn_file.c>
 AuthType Basic
 AuthName "Protected"
 AuthUserFile /var/www/address_from_getcwd_command_check_php/.htpasswd
 Require user TheUserName
</IfModule>
```
While we are referencing the "/var/www/address_from_getcwd_command_check_php/.htpasswd" file, we need to add this one to the .htaccess file location. The easiest way is to generate one via web service. I could recommend the following page: http://www.htaccesstools.com/htpasswd-generator/ . Enter the TheUserName of your choice and store the output file right to the .htaccess file (project root folder).
After that while accessing your project, you will be requested to enter the user and password. If you fail to login, you need to clear cache of your browser (hold the SHIFT key while clicking reload).