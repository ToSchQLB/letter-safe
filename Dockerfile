FROM php:7.2-apache

#install software
RUN apt-get update && apt-get -y install \
        tesseract-ocr \
        tesseract-ocr-deu \
        tesseract-ocr-eng \
        imagemagick \
        poppler-utils \
        wget \
        git \
        zlib1g-dev \
        libpng-dev \
        libzip-dev \
        cron \
        libmagickwand-dev

#install PHP-Modules
RUN docker-php-ext-install \
        mbstring \
        zip \
        gd \
        mysqli \
        pdo \
        pdo_mysql \
&& pecl install imagick-3.4.3 \
&& docker-php-ext-enable imagick \
&& cd /var/www/html \
&& mkdir letter-safe

COPY . letter-safe

RUN wget -q https://getcomposer.org/composer.phar \
    && cd letter-safe \
    && php ../composer.phar install \
    && php ../composer.phar update

ENV LETTERSAFE_DB_SERVER db
ENV LETTERSAFE_DB_DB letter-safe
ENV LETTERSAFE_DB_USER letter-safe
ENV LETTERSAFE_DB_PASSWORD letter-safe

WORKDIR /var/www/html/letter-safe

COPY docker/entrypoint.sh /var/www/html/letter-safe/entrypoint.sh
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php.ini-production /usr/local/etc/php/conf.d/php.ini

#Schreibrechte und Crontab
RUN chmod 0777 /var/www/html/letter-safe/web/assets \
&& chmod -R 0777 /var/www/html/letter-safe/runtime \
&& chmod -R 0777 /var/www/html/letter-safe/web/data \
&& chmod 0777 /var/www/html/letter-safe/entrypoint.sh \
&& echo "* *   * * *   root    php /var/www/html/letter-safe/yii queue/execute > /dev/null 2>&1 &" >> /etc/crontab

ENTRYPOINT ["./entrypoint.sh"]

EXPOSE 80/tcp
