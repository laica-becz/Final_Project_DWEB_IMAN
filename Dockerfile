FROM php:8.2-apache

# Install PDO MySQL extension (needed for your db_conn.php)
RUN docker-php-ext-install pdo pdo_mysql

# Copy your project files into the container
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html
