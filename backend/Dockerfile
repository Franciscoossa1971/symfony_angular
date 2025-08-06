FROM php:8.2-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Symfony
RUN composer install

# Exponer puerto
EXPOSE 8080

# Ejecutar el servidor embebido de Symfony
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
