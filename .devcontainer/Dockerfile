FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) bcmath gd zip mysqli exif pdo pdo_mysql

ADD custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN curl -sL https://deb.nodesource.com/setup_18.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install nodejs -y
RUN rm nodesource_setup.sh
RUN corepack enable
RUN yarn set version stable
RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer self-update --2

ENV APACHE_DOCUMENT_ROOT /home/app

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY app.conf /etc/apache2/sites-available/app.conf

RUN a2ensite app.conf
RUN a2dissite 000-default.conf
RUN service apache2 restart

RUN useradd -ms /bin/bash app

RUN mkdir -p /home/app
RUN chown -R app:app /home/app