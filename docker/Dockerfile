# Default PHP tinker image Kees Gerbers
FROM php:8-fpm

ARG USER_ID
ARG GROUP_ID
ARG NODE_MAJOR
ARG APP_BUILT_ENV

RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data;

RUN apt-get update && apt-get install -y ca-certificates curl gnupg && \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_${NODE_MAJOR}.x nodistro main" > /etc/apt/sources.list.d/nodesource.list


RUN mkdir -p /usr/local/etc/openssl/ && \
    curl https://curl.se/ca/cacert.pem --output /usr/local/etc/openssl/cert.pem --silent && \
    apt-get update && apt-get upgrade -y &&  apt-get install -y \
        libcurl4-openssl-dev \
        build-essential \
        libxml2-dev \
        git \
        supervisor \
        nginx \
        libzip-dev \
        libxml2-dev \
     && apt-get clean all;

# Configure php packages
# Installing redis from source, because pecl has no direct to install for php8 and php-ext-install does also not support redis
RUN docker-php-ext-install \
        curl \
        xml \
        intl \
        opcache \
        soap \
        zip \
        xml;

RUN  php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# For enabling npm running inside the container
RUN mkdir -p "/root/.composer/" && \
    mkdir -p "/root/.composer/cache/vcs" && \
    chown -R 1000:1000 "/root/.composer/" && \
    chmod -R 777 /root/.composer/

# put configs in place
COPY "./php.ini" /usr/local/etc/php/php.ini
COPY "./supervisord.conf" /etc/supervisord.conf
RUN echo '[www] \n\
listen = /var/run/php-fpm.sock; \n\
listen.owner = www-data; \n\
listen.group = www-data; ' > /usr/local/etc/php-fpm.d/zzz-custom.conf

# Nginx config
RUN echo 'server {\n\
  root /usr/share/nginx/html;\n\
\n\
  add_header X-Frame-Options "SAMEORIGIN";\n\
  add_header X-Content-Type-Options "nosniff";\n\
  add_header 'Content-Security-Policy' 'upgrade-insecure-requests';\n\
\n\
  index index.php index.html;\n\
\n\
  charset utf-8;\n\
  client_max_body_size 64M;\n\
\n\
  location / {\n\
   try_files $uri $uri/ /index.php?$query_string;\n\
  }\n\
\n\
  location = /favicon.ico { access_log off; log_not_found off; }\n\
  location = /robots.txt  { access_log off; log_not_found off; }\n\
\n\
  error_page 404 /index.php;\n\
\n\
  location ~ \.php$ {\n\
        fastcgi_pass unix:/var/run/php-fpm.sock;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
  }\n\
\n\
  location ~ /\.(?!well-known).* {\n\
        deny all;\n\
  }\n\
}' > /etc/nginx/sites-enabled/default

# Redirect logging to docker output
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

expose 3000

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

# Work around to default login to the www-data user for running manual commands
# USER directive cannot be used because supervisord must be run as root.
RUN echo "su www-data -s /bin/bash" > /root/.bashrc

# Handy aliases
RUN echo 'alias ll="ls -alh"' >  /home/www-data/.bashrc

USER www-data

COPY . /usr/share/nginx/html/

USER root

WORKDIR /usr/share/nginx/html/
