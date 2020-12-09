FROM phpdockerio/php74-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.4-memcached php7.4-mysql php7.4-redis php7.4-xdebug php7.4-bcmath php7.4-bz2 php7.4-dba php7.4-enchant php7.4-gd php7.4-imap php7.4-intl php7.4-mongodb php7.4-phpdbg php7.4-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* & \
	curl -sS https://getcomposer.org/install
	
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
	