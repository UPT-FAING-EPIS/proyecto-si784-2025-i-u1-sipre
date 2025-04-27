# Usar una imagen base de PHP con Apache
FROM php:8.1-apache

# Copiar los archivos del proyecto al directorio de Apache en el contenedor
COPY . /var/www/html/

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Exponer el puerto 80
EXPOSE 80
