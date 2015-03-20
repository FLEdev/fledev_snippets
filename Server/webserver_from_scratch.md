Webserver build up from scratch

Install Linux distribution (providers are having prepared packages that you start like: $ installimage)
After installing and rebooting, login via ssh - Putty or Terminal
$ apt-get update // to renew the package list
$ apt-get install mc // install terminal commander
$ mkdir /home/www   // create the default www directory
$ passwd root  // change the root password. Pay attention of character divesivity within your password

Installing nginx:
$ sudo apt-get install nginx
$ service nginx start
# /etc/nginx/ is the default configuration folder. Use the site-available and sites-enabled to add virtual hosts
# default www folder is set to: /usr/share/nginx/www

Install PHP
$ apt-get install php5 php5-fpm
$ nano /etc/php5/fpm/pool.d/www.conf
// now just copy the "listen = /var/run/php5-fpm.sock" (if not already uncommented) path and edit the nginx default configuration folder (~ line 62 regarding php):
$ nano /etc/nginx/sites-available/default    // to:

location ~ \.php$ {                              # uncomment
    fastcgi_split_path_info ^(.+\.php)(/.+)$;    # uncomment
#    # NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini

#    # With php5-cgi alone:
#    fastcgi_pass 127.0.0.1:9000;
    # With php5-fpm:
    fastcgi_pass unix:/var/run/php5-fpm.sock;    # uncomment
    fastcgi_index index.php;                     # uncomment
    include fastcgi_params;                      # uncomment
}
$ nginx -s reload
# nano /usr/share/nginx/www and add "<?php phpinfo();". Save file
Install PHP-APC:
$ apt-get install php-apc
$ sudo nano /etc/php5/fpm/conf.d/20-apc.ini
add:
extension=apc.so

apc.enabled=1
apc.shm_size=128M
apc.ttl=3600
apc.user_ttl=7200
apc.gc_ttl=3600
apc.max_file_size=1M
$ service php5-fpm restart
Install MariaDB:
https://downloads.mariadb.org/mariadb/repositories/

$ sudo apt-get install python-software-properties
$ sudo apt-key adv --recv-keys --keyserver keyserver.ubuntu.com 0xcbcb082a1bb943db
$ sudo add-apt-repository 'deb <a href="http://ftp.osuosl.org/pub/mariadb/repo/10.0/debian">http://ftp.osuosl.org/pub/mariadb/repo/10.0/debian</a> wheezy main'

$ sudo apt-get update
$ sudo apt-get install mariadb-server
$ mysql -V  // check for DB version
Install phpMyAdmin:
$ apt-get install phpmyadmin
// !!! while istalling, due nginx non standard procedure:
// !!! Web server to reconfigure automatically: NONE SELECTING -> Tab OK && Configure database for phpmyadmin with dbconfig-common? -> NO

Creating Vhosts on Nginx:
. $ cp /etc/nginx/sites-avilable/default /etc/nginx/sites-available/vhost1.loc
. $ nano /etc/nginx/sites-available.vhost1.loc // and add:
. Drupal sites-available version: http://wiki.nginx.org/Drupal

server {
    listen 80;

    # localhost
    # root /home/server/www/;
    # server_name localhost;

    # PhpMyAdmin
    # root /usr/share/phpmyadmin;
    # server_name pma.loc;

    # other virtual host
    # root /home/server/www/vhost1_com/;
    # server_name vhost1.loc;

    # location /administration/ {
    #    auth_basic  "devCU Admin Restricted Area";
    #    auth_basic_user_file  /etc/nginx/htpasswd;
    # }
    error_page 404 /home/server/www/logs/404.html;
    access_log /home/server/www/logs/vhost1.log;

    index index.php index.html;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }

     # static file 404's aren't logged and expires header is set to maximum age
    location ~* \.(jpg|jpeg|gif|css|png|js|ico|html)$ {
        access_log off;
        log_not_found off;
        expires max;
    }

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }
    location = /robots.txt {
        allow all;
        log_not_found off;
        access_log off;
    }
    # Make sure files with the following extensions do not get loaded by nginx because nginx would
    # display the source code, and these files can contain PASSWORDS!

    location ~* \.(engine|inc|info|install|make|module|profile|test|po|sh|.*sql|theme|tpl(\.php)?|xtmpl)$|^(\..*|Entries.*|Repository|Root|Tag|Template)$|\.php_ {
        deny all;
    }

    location ~ /\.ht {
        deny  all;
    }

    # Deny all attempts to access hidden files such as .htaccess, .htpasswd, .DS_Store (Mac).
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }
}
. $ sudo nano /etc/hosts
. within this, add 127.0.0.1    vhost1.loc # serverName
. $ ln /etc/nginx/sites-available/vhost1.loc /etc/nginx/service-enabled/vhost1.loc
. $ service nginx restart
Install CURL and Drush:
. $ apt-get install drush
. $ apt-get install curl
Install FTP:
$ apt-get install vsftpd
!!! $ sudo nano /etc/vsftpd.conf   # and disable the anonymous_enable=YES to NO  && anon_upload_enable=NO
Enable for authentificated users: local_enable=YES && write_enable=YES
$ watch ps -C vsftpd -o user,pid,stime,cmd # Monitor svftpd ftp connections [CTRL] + x to exit
$ openssl genrsa -des3 -out server.key 1024  # key generation
// https://help.ubuntu.com/10.04/serverguide/ftp-server.html
// http://cviorel.easyblog.ro/2009/03/05/how-to-setup-vsftpd-ftp-on-ubuntu-...
Install GIT (server)
$ adduser git
$ su git
$ ssh-keygen -t rsa -C "your_email@example.com"


$ cd
$ mkdir .ssh
$ cd .ssh
$ nano authorized_keys #enter ssh public key of users
$ chmod 700 !$
$ chmod 600 /home/git/.ssh/*
$ cd
$ mkdir project.git
$ cd project.git
$ git init --bare --shared
$ exit
$ chown -R git:git /home/.../www/deploymentDirectory  # change group ownership to be able to join folder
$ nano /etc/passwd     # ->  git:x:1000:1000::/home/git:/usr/bin/git-shell    !!! inportant!!!

On home computer:
$ git config core.autocrlf
$ apt-get install rubygems build-essential  # install gem
$ gem install git-deploy


$ git clone git@serverIP # or:
$ git init
$ git remote add origin git@serverIP:myrepo.git



# then:
$ git remote add production "user@example.com:/apps/mynewapp/anyFolder"
$ git deploy setup -r "production"
$ git deploy init
$ git push production master


# https://github.com/mislav/git-deploy
$ nano /etc/passwd  # change the bash to rbash
$ usermod -d /path/to/new/homedir/ username #change the users home directory if needed

Install Mail service:
#install postfix and dovecot

$ apt-get update

$ apt-get install postfix dovecot-common dovecot-pop3d dovecot-imapd
$ nano /etc/main.cf

masquerade_domains = domain1.com domain2.com tralala.org example.com

virtual_mailbox_domains = domain1.com, domain2.com, tralala.org, example.com
virtual_mailbox_base = /var/spool/mail
virtual_mailbox_maps = hash:/etc/postfix/virtual
virtual_uid_maps = static:1003
virtual_gid_maps = static:1003

$ cd /var/spool/mail

$ mkdir domain1.com

$ chmod 777 domain1.com
$ nano /etc/postfix/virtual
@domain1.org          domain1.org/

info@domain1.org      domain1.org/info

# local hostname lookup

$ hostname --fqdn
$ postqueue -p
Youtube tutorial

Install Varnish:
$ sudo apt-get install varnish
$ sudo nano /etc/default/varnish
DAEMON_OPTS="-a :80 \
             -T localhost:6082 \
             -f /etc/varnish/default.vcl \
             -S /etc/varnish/secret \
             -s malloc,256m"
$ sudo nano /etc/varnish/default.vcl

backend default {

    .host = "127.0.0.1";

    .port = "8080";

}
$ sudo nano /etc/apache2/ports.conf

NameVirtualHost 127.0.0.1:8080

Listen 127.0.0.1:8080
$ sudo nano /etc/apache2/sites-available/default

<VirtualHost 127.0.0.1:8080>
$ sudo service apache2 restart
$ sudo service varnish restart


Off topic:
// This does the same by adding to the /root/.bashrc file via $ nano .bashrc:

function cs() {
  if [ $# -eq 0 ]; then
    cd && ls
  else
    cd "$*" && ls
  fi
}
alias cd='cs'
# save and run:
$ source ~/.bashrc
Add linux mint repository on Debian: $ add-apt-repository "http://packages.linuxmint.com debian import"
In the visual mode try GUAKE terminal view mode by pressing F4 or F12 key ( sudo apt-get install guake)
add a good utility to list files at change directory unter the alias of $ cl - change list: $ cl() { cd "$@" && ls; }
list active users: $ cat /etc/passwd | cut -d":" -f1
set on client to ignore the line ending CRLF issues: $ git config core.autocrlf false
$ tail -n300 /path/to/file/error.log | grep whatToHighilight
kill all user processes: $ pkill -u USERNAME
delete user: $ userdel -r USERNAME
Shows server connections: $ netstat -n -A inet
show activity of user: $ w username
system monitor: $ nethogs
actual connection list: $ lsof -i
show authentification log: $ tail -f /var/log/auth.log
ban ip: $ iptables -A INPUT -s 82.209.218.91 -j DROP
search for text in files: $ grep -r -i -l -H "redeem reward" ~/*.txt | tee file.txt
Search: $ find /usr -type l
Directory size lookup: $ du -hs
sudo cp /usr/share/applications/guake.desktop /etc/xdg/autostart/

cd /where/to/enter/after/login



function cd {

 builtin cd "$@" && ls -la

}
if [ -x /usr/bin/dircolors ]; then

    test -r ~/.dircolors && eval "$(dircolors -b ~/.dircolors)" || eval "$(dircolors -b)"

    alias ls='ls --color=auto'

    #alias dir='dir --color=auto'

    #alias vdir='vdir --color=auto'



    alias grep='grep --color=auto'

    alias fgrep='fgrep --color=auto'

    alias egrep='egrep --color=auto'

fi


/*
Links:

https://www.howtoforge.com/running-phpmyadmin-on-nginx-lemp-on-debian-squeeze-ubuntu-11.04
http://nginx.org/en/docs/beginners_guide.html
http://www.binarytides.com/install-nginx-php-fpm-mariadb-debian/
http://kidsreturn.org/2012/08/nginx-phpmyadmin-vhost-config/
https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-varnish-with-apache-on-ubuntu-12-04--3
*/










