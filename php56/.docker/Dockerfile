FROM centos:7

MAINTAINER "Maximo Mena" <mmenavas@asu.edu>

ENV container docker
ENV user rtd

# Add EPEL and Webtatic repos
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm \
 && rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm

# Normal updates
RUN yum -y update

# PHP, HTTPD, and other tools
RUN yum -y install \
    httpd \
    mod_ssl \
    which \
    php56w \
    php56w-cli \
    php56w-common \
    php56w-gd \
    php56w-intl \
    php56w-ldap \
    php56w-mbstring \
    php56w-mcrypt \
    php56w-mssql \
    php56w-mysql \
    php56w-odbc \
    php56w-opcache \
    php56w-pdo \
    php56w-pear \
    php56w-pecl-xdebug \
    php56w-soap \
    php56w-xml \
    php56w-xmlrpc \
    php50w-ldap \
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
RUN useradd -ms /bin/bash ${user}
RUN ln -s /home/${user}/.composer/vendor/bin/drush /usr/local/bin/drush

# Install drush
RUN su - rtd -c "composer global require  drush/drush:8.x"

# Additional configuration
EXPOSE 80 443
WORKDIR /var/www/app

# Start apache
CMD ["/bin/bash", "/scripts/start.sh"]
