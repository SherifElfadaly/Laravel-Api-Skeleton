FROM php:7.4-apache

RUN apt-get update

# development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libonig-dev\
    libzip-dev\
    g++

# apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip

RUN docker-php-source extract && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    docker-php-source delete

# composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && composer global require hirak/prestissimo --no-plugins --no-scripts

# copy files
COPY . /var/www/html

# composer install
COPY composer.json /var/www/html/composer.json

RUN if [ "$env" = "prod" ]; \
    then  composer install --no-dev --optimize-autoloader; \
	else  composer install --optimize-autoloader;  \
	fi

RUN rm -rf /root/.composer

# create env file based on env variable
ARG env
RUN if [ "$env" = "prod" ]; \
    then  cp .env-prod .env; \
	else  cp .env-dev .env;  \
	fi

# clear cach and restart queue
RUN php artisan clear-compiled && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    php artisan route:cache && \
    composer dump-autoload -a && \
    php artisan queue:restart

# run migrations and seeds
RUN php artisan module:migrate && \
    php artisan module:seed