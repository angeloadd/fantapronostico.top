# Steps

Run marketplace app
add domain and put in DNS in godaddy the three digital ocean dns:
```
ns1.digitalocean.com
ns2.digitalocean.com
ns3.digitalocean.com
```
After the domains are active go run the first ssh session:

activate app and run certbot (if live folder is not present run certbot certonly be sure to do it before adding the following nginx config):

```
server {
    server_name _ fantapronostico.top www.fantapronostico.top;
    root /var/www/html/fantapronostico.top/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    listen 443 ssl; # managed by Certbot
    ssl_certificate /etc/letsencrypt/live/fantapronostico.top/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/fantapronostico.top/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
}

server {
     #Force all HTTP traffic to SSL
    listen 80;
    return 301 https://$host$request_uri;
}
server {
    # Redirect www.example.com to example.com
    listen 443 ssl;

    #This needs to be the cert for www.fantapronostico.top or *.example.com
    ssl_certificate /etc/letsencrypt/live/fantapronostico.top/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/fantapronostico.top/privkey.pem;
    include /etc/letsencrypt/options-ssl-nginx.conf;
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem;

    #Remember, if nginx doesnt find the server_name, it uses the first vhost.
    server_name www.fantapronostico.top;
    return 301 https://fantapronostico.top$request_uri;
}
```
https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-laravel-with-nginx-on-ubuntu-20-04
This config enables https. Then run mysql secure installation and apply firewalls following the guides in the marketplace page:
[https://marketplace.digitalocean.com/apps/laravel](https://marketplace.digitalocean.com/apps/laravel)

following install posgresql and follow this guide:
```shell
sudo apt install postgresql
sudo apt install php(phpv)-pgsql
```

https://ubuntu.com/server/docs/install-and-configure-postgresql

check nginx status `sudo nginx -t`
reload nginx `sudo systemctl reload nginx`

remember to change user for storage and cache `chown -R www-data:www-data folder` -R stands for recursive

`crontab -e`
`* * * * * cd /var/www/html/fantapronostico.top && php artisan schedule:run >> /dev/null 2>&1`
`sudo service cron reload`
