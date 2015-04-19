```
server {
    listen *:80;
    server_name your_domain.com www.your_domain.com;
    root   /var/www/your_folder/web;

    index index.html index.htm index.php index.cgi index.pl index.xhtml;

    # any other location try files first and forward to front controller afterwards
    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~* \.php$  {
        try_files $uri =404;
        include /etc/nginx/fastcgi_params;
        fastcgi_pass unix:/var/lib/php5-fpm/web3.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_intercept_errors on;
    }

    error_log /var/log/ispconfig/httpd/your_domain.com/error.log;
    access_log /var/log/ispconfig/httpd/your_domain.com/access.log combined;

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }

    location = /robots.txt {
        allow all;
        log_not_found off;
        access_log off;
    }
}
```