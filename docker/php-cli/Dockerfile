# Warnings :
# * This Docker file must be buit from project root folder
FROM php:8.3-cli-bullseye

# Install dependencies
RUN apt-get update && apt-get install --no-install-recommends -yq ${BUILD_PACKAGES} \
        build-essential \
        # For XSL extension
        libxslt-dev \
        # For PostgreSQL (client)
        libpq-dev \
        # For GD
        libfreetype6-dev \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        # Misc PHP extensions dependencies
        libmcrypt-dev \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        # For image optimization
        pngquant \
        jpegoptim \
        # Some useful tools
        wget \
        gnupg2 \
        ssh \
        git \
        pigz \
        unzip

# Some recommended PHP extensions
ENV PHP_EXTENSIONS mbstring opcache pdo_pgsql pdo_mysql pcntl intl xsl zip
RUN docker-php-ext-install ${PHP_EXTENSIONS}
# and Redis
RUN pecl channel-update pecl.php.net && pecl install redis-5.3.4
RUN docker-php-ext-enable redis
# and GD
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ --with-webp=/usr/include/ \
    && docker-php-ext-install gd

# Adding composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin
ENV PATH="$PATH:/root/.config/composer/vendor/bin:/root/.composer/vendor/bin/"

# And some plugins
RUN composer global require "friendsofphp/php-cs-fixer" --prefer-dist --no-progress --optimize-autoloader --classmap-authoritative \
    && composer clear-cache

# Adding symfony command
RUN wget https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh -O - | bash
RUN apt-get install symfony-cli
