FROM php:7.4-fpm-alpine

ENV DATA_ROOT /data

WORKDIR ${DATA_ROOT}

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN mkdir -p ${DATA_ROOT}/public
RUN mkdir -p ${DATA_ROOT}/var/log
RUN chmod -R 777 ${DATA_ROOT}/var/log

COPY deploy/php-fpm/php-fpm.d /usr/local/etc/php-fpm.d
COPY .env* ${DATA_ROOT}/
COPY composer.* ${DATA_ROOT}/

COPY bin/ bin/
COPY config/ config/
COPY src/ src/
COPY public/ public/
COPY vendor/ vendor/