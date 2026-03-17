FROM php:8.3-apache

# Enable rewrite module
RUN a2enmod rewrite

# Copy files
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/rooms /var/www/html/sessions /var/www/html/assets

# Fix Apache ports for Render (replace Listen 80, VirtualHost)
RUN sed -i '/^Listen 80/c\Listen 10000' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \\*:80>/<VirtualHost \\*:10000>/g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/NameVirtualHost .*/& # commented for Render/' /etc/apache2/apache2.conf || true

EXPOSE 10000

CMD ["apache2-foreground"]
