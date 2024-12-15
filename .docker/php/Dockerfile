FROM php:8.2-apache

# Instalação de pacotes
RUN apt-get update
RUN apt-get install -y \
	wget \
	libpng-dev \
	nginx \
	supervisor \
	nano \
	libxml2-dev \
	git \
	zip \
	autoconf \
	g++ \
	libzip-dev \
	unixodbc \
	unixodbc-dev \
    freetds-dev freetds-bin tdsodbc \
	gnupg gnupg1 gnupg2 \
    curl && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

RUN ln -s /usr/lib/x86_64-linux-gnu/libsybdb.a /usr/lib/

# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        gd \
        soap \
        xml \
        posix \
        ctype \
        pcntl \
        opcache \
        bcmath \
        zip \
        gd \
    	exif


# Instalação do composer, cópia dos arquivos necessários e permissões de acesso
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

COPY .docker/php/setup.sh ./setup.sh

COPY .docker/php/php.ini "$PHP_INI_DIR/php.ini"

# Set up Laravel front-end
WORKDIR /var/www/html
RUN npm install

RUN chmod +x ./setup.sh && ./setup.sh
