FROM php:8.2-apache

# Activer mod_rewrite pour les URLs propres
RUN a2enmod rewrite

# Activer mod_deflate pour la compression GZIP
RUN a2enmod deflate

# Activer mod_expires pour le cache navigateur
RUN a2enmod expires

# Activer mod_headers pour les headers de sécurité
RUN a2enmod headers

# Installer l'extension intl pour transliterator_transliterate
# Installer Node.js pour build Tailwind CSS
RUN apt-get update && apt-get install -y libicu-dev nodejs npm \
    && docker-php-ext-install intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configuration Apache - AllowOverride All pour .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Augmenter la limite des headers (évite "Size of a request header field exceeds server limit")
RUN echo "LimitRequestFieldSize 32768" >> /etc/apache2/apache2.conf \
    && echo "LimitRequestLine 32768" >> /etc/apache2/apache2.conf

# Copier les fichiers du projet
COPY . /var/www/html/

# Build Tailwind CSS
WORKDIR /var/www/html
RUN npm install && npm run build:css

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
