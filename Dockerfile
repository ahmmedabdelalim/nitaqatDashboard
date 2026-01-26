FROM php:8.4-apache

WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    lsb-release \
    gnupg \
    git \
    unzip \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    gettext \
    nano \
    vim \
    default-mysql-client \
    cron \
    iputils-ping \
    netcat-openbsd \
 && docker-php-ext-configure gd \
 && docker-php-ext-install pdo_mysql gd zip mbstring exif pcntl bcmath opcache gettext intl \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*


# 👉 Install Node.js & npm
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
 && apt-get install -y nodejs \
 && npm install -g npm@latest

COPY . .

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer



COPY ./docker_entrypoint.sh /usr/local/bin/docker_entrypoint.sh
RUN chmod +x /usr/local/bin/docker_entrypoint.sh


ENTRYPOINT [ "docker_entrypoint.sh" ]
 
# Apache normally listens on 80, 
# if you want Laravel serve inside container use 8000
EXPOSE 80 8005




