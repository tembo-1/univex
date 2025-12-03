FROM php:8.4-fpm

# Установка необходимых зависимостей
RUN apt-get update && apt-get install -y \
      apt-utils \
      supervisor \
      libpq-dev \
      libpng-dev \
      gettext \
      libzip-dev \
      zip unzip \
      libxml2-dev \
      git \
      wget \
      build-essential \
      zlib1g-dev \
      libssl-dev \
      libicu-dev && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка других PHP-расширений
RUN docker-php-ext-install pdo_mysql pdo_pgsql bcmath opcache gd zip soap pcntl intl && \
    docker-php-ext-enable pdo_mysql pdo_pgsql intl

# Копирование файла конфигурации PHP
COPY ./php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Установка Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Установка рабочей директории
WORKDIR /var/www

# Копируем entrypoint-скрипт
COPY ./php/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Устанавливаем его как точку входа
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
