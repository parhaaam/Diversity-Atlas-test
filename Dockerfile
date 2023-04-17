FROM webdevops/php-nginx:8.1

COPY . /app

WORKDIR /app

    
RUN rm -rf /opt/docker/etc/nginx/vhost.conf           &&\
    rm -rf /etc/nginx/conf.d/10-docker.conf           &&\
    mv nginx/nginx.conf /etc/nginx/conf.d/nginx.conf  &&\
    chown -R www-data:www-data /app                   &&\
    chmod -R 755 /app                                 &&\
    chmod -R 777 storage                              &&\
    composer install                                  &&\
    php artisan optimize:clear                        &&\
    php artisan key:generate                          &&\
    php artisan storage:link
