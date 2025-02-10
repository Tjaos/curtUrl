# Usando uma imagem oficial do PHP
FROM php:8.2-fpm

# Instalando dependências do sistema e PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Definir o diretório de trabalho para /var/www
WORKDIR /var/www

# Copiar o arquivo de código-fonte para dentro do container
COPY . .

# Instalar dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar as dependências do Laravel via Composer
RUN composer install --no-interaction --optimize-autoloader

# Expor a porta do PHP-FPM
EXPOSE 9000

# Definir o comando para rodar o PHP-FPM
CMD ["php-fpm"]
