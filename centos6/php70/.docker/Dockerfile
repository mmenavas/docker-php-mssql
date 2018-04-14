FROM centos:6

MAINTAINER "Maximo Mena" <mmenavas@asu.edu>

ENV CONTAINER docker
ENV USER rtd
ENV PHPVERSION 70


# Add EPEL and Webtatic repos
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-6.noarch.rpm \
 && rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm

# Normal updates
RUN yum -y update

# PHP, HTTPD, and other tools
RUN yum -y install \
    httpd \
    mod_ssl \
    which \
    php${PHPVERSION}w \
    php${PHPVERSION}w-cli \
    php${PHPVERSION}w-common \
    php${PHPVERSION}w-gd \
    php${PHPVERSION}w-intl \
    php${PHPVERSION}w-ldap \
    php${PHPVERSION}w-mbstring \
    php${PHPVERSION}w-mcrypt \
    php${PHPVERSION}w-mssql \
    php${PHPVERSION}w-mysql \
    php${PHPVERSION}w-odbc \
    php${PHPVERSION}w-opcache \
    php${PHPVERSION}w-pdo \
    php${PHPVERSION}w-pear \
    php${PHPVERSION}w-pecl-xdebug \
    php${PHPVERSION}w-soap \
    php${PHPVERSION}w-xml \
    php${PHPVERSION}w-xmlrpc \
    php${PHPVERSION}w-ldap \
    patch \
    mysql \
    curl \
    git \
 && yum clean all

# Transfer files from host
COPY php/ /etc/php.d/
COPY apache/v-host.conf /etc/httpd/conf.d/
COPY apache/ssl.conf /tmp/ssl.conf
COPY mssql/odbcinst.ini /tmp/odbcinst.ini
COPY scripts /scripts

# Configuration changes
RUN rm -rf /etc/localtime \
 && ln -s /usr/share/zoneinfo/America/Phoenix /etc/localtime \
 && cat /tmp/odbcinst.ini >> /etc/odbcinst.ini \
 && sed -i -e 's/#DocumentRoot "\/var\/www\/html"/DocumentRoot "\/var\/www\/app"/' /etc/httpd/conf.d/ssl.conf \
 && sed -i -e '/ServerName/r /tmp/ssl.conf' /etc/httpd/conf.d/ssl.conf

 # Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --install-dir=bin --filename=composer \
 && php -r "unlink('composer-setup.php');"

 # Add non root user
RUN useradd -ms /bin/bash ${USER}
RUN ln -s /home/${USER}/.composer/vendor/bin/drush /usr/local/bin/drush

# Install drush
RUN su - ${USER} -c "composer global require  drush/drush:8.x"

# Additional configuration
EXPOSE 80 443
WORKDIR /var/www/app

# Start apache
CMD ["/bin/bash", "/scripts/start.sh"]
