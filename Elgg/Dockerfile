FROM php:8.2-fpm-bookworm

COPY elgg-install.php /elgg-install.php
COPY entrypoint.sh /entrypoint.sh

RUN apt-get update && \
 apt-get install -y zip unzip curl libcurl3-dev libzip-dev libpng-dev libssl-dev libmemcached-dev libjpeg-dev libonig-dev libxml2-dev libzip-dev  libfreetype6-dev libwebp-dev libmcrypt-dev

# Elgg requirements
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp; 
RUN docker-php-ext-install curl
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install xml
RUN docker-php-ext-install intl
RUN docker-php-ext-install zip
RUN docker-php-ext-install opcache

# Install and configure ImageMagick
RUN apt-get install -y libmagickwand-dev
RUN apt-get install -y dos2unix
RUN pecl install imagick
RUN pecl install memcached
RUN pecl install redis-6.0.2
RUN docker-php-ext-enable redis
RUN docker-php-ext-enable imagick
RUN docker-php-ext-enable memcached

RUN apt-get purge -y libmagickwand-dev

# Correct line-endings and encoding stuff
RUN dos2unix /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Elgg version to use default 5.1.0
ENV ELGG_VERSION=${ELGG_VERSION:-"5.1.0"}

# Set Timezone
ENV TIMEZONE=${TIMEZONE:-"Europe/Berlin"}
RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime
# RUN sed -i "s#{{timezone}}#$TIMEZONE#g" /usr/local/etc/php/php.ini

# Optional instasll Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Download Elgg and use temporary Install dir
RUN mkdir -p /elgg-install
RUN curl --output /elgg-install/elgg-${ELGG_VERSION}.zip https://github.com/Elgg/Elgg/releases/download/${ELGG_VERSION}/elgg-${ELGG_VERSION}.zip -L && unzip /elgg-install/elgg-${ELGG_VERSION}.zip -d /elgg-install && rm /elgg-install/elgg-${ELGG_VERSION}.zip

#
# Database
ENV ELGG_DB_HOST=${ELGG_DB_HOST:-"elgg-db"}
ENV ELGG_DB_USER=$MYSQL_USER
ENV ELGG_DB_PASS=$MYSQL_PASS
ENV ELGG_DB_NAME=${ELGG_DB_NAME:-"elgg"}
ENV ELGG_DB_PORT=${MYSQL_PORT:-"3306"}
ENV ELGG_DB_PREFIX=${ELGG_DB_PREFIX:-"elgg_"}

# Elgg admin account
ENV ELGG_DISPLAY_NAME=${ELGG_DISPLAY_NAME:-"Admin"}
ENV ELGG_EMAIL=${ELGG_EMAIL:-"adminmail@yourelgg.com"}
ENV ELGG_USERNAME=${ELGG_USERNAME:-"admin"}
ENV ELGG_PASSWORD=${ELGG_PASSWORD:-"admin-password"}

ENV ELGG_SITE_NAME=${ELGG_SITE_NAME:-"My Elgg Site"}
ENV ELGG_DATA_ROOT=${ELGG_DATA_ROOT:-"/var/www/data/"}
ENV ELGG_WWW_ROOT=${ELGG_WWW_ROOT:-"http://localhost/"}
ENV ELGG_SITE_ACCESS=${ELGG_SITE_ACCESS:-"2"}
ENV ELGG_PATH=${ELGG_PATH:-"/var/www/html/"}

RUN mkdir -p ${ELGG_PATH}
RUN mkdir -p ${ELGG_DATA_ROOT}
RUN chown -R www-data:root ${ELGG_PATH}
RUN chown -R www-data:root ${ELGG_DATA_ROOT}

VOLUME ${ELGG_PATH}

WORKDIR ${ELGG_PATH}

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]
