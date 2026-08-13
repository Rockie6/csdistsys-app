FROM php:8.2-apache

RUN apt-get update && apt-get install -y libpq-dev && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql pdo_pgsql

# open the app on the signup form instead of the records table
RUN printf 'DirectoryIndex signup.php index.php\n' > /etc/apache2/conf-available/signup-index.conf && a2enconf signup-index

COPY . /var/www/html/

EXPOSE 80
