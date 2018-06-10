# USAGE
# docker build \
#  --build-arg 'COMPOSER_AUTH={"github-oauth":{"github.com":"YourGHOAuthTokenHere"}}' \
#  --tag doroflex:latest .

# --------------------------------------------------------------------------------------------------------------------

FROM php:7.2-alpine AS dependencies

ARG COMPOSER_AUTH
ARG APP_ENV

# Install composer
RUN apk update \
    && apk add ca-certificates coreutils \
    && wget -q https://getcomposer.org/installer -O composer-setup.php \
    && wget -q https://composer.github.io/installer.sha384sum -O installer.sha384sum \
    && sha384sum installer.sha384sum \
    && php composer-setup.php --install-dir /usr/local/bin

# Add our application files here
ADD src /app/src
ADD bin /app/bin
ADD config /app/config
ADD public /app/public
ADD var /app/var
ADD composer.* /app/
ADD symfony.* /app/
ADD .env /app/
WORKDIR /app

# Install deps
RUN composer.phar install --no-dev --classmap-authoritative --no-suggest
ADD vendor /app/vendor

# --------------------------------------------------------------------------------------------------------------------

# REAL application container
FROM php:7.2.6-fpm-alpine3.7

# Install PHP modules
RUN apk --update add \
        php7-bcmath \
        php7-dom \
        php7-ctype \
        php7-curl \
        php7-fileinfo \
        php7-gd \
        php7-iconv \
        php7-intl \
        php7-json \
        php7-mbstring \
        php7-opcache \
        php7-openssl \
        php7-pdo \
        php7-pdo_pgsql \
        php7-phar \
        php7-posix \
        php7-redis \
        php7-simplexml \
        php7-session \
        php7-tokenizer \
        php7-xml \
        php7-xmlreader \
        php7-xmlwriter \
        php7-zip

# Install nginx and supervisor
RUN apk --update add \
        nginx \
        supervisor \
        bash \
    && rm -rf /var/cache/apk/*

# Embed configuration files
ADD deploy/docker/php.ini /etc/php7/conf.d/50-setting.ini
ADD deploy/docker/php-fpm.conf /etc/php7/php-fpm.conf
ADD deploy/docker/nginx.conf /etc/nginx/nginx.conf
ADD deploy/docker/nginx-app.conf /etc/nginx/conf.d/default.conf
ADD deploy/docker/fastcgi_fpm_params.conf /etc/nginx/fastcgi.conf
ADD deploy/docker/supervisor.conf /etc/supervisor.d/app.ini


# we don't need to do anything here by copy the `/app` folder from the
# `dependencies` stage above. Its /app folder will have all the vendor files etc
COPY --from=dependencies /app /app

EXPOSE 80

CMD ["/usr/bin/supervisord"]

