#!/bin/bash

apache_config_file="/etc/apache2/envvars"
apache_vhost_file="/etc/apache2/sites-available/vagrant_vhost.conf"
php_config_file="/etc/php5/apache2/php.ini"
phpcli_config_file="/etc/php5/cli/php.ini"
composer_config_file"/home/vagrant/.composer/config.json"
xdebug_config_file="/etc/php5/mods-available/xdebug.ini"
postgres_conf_file="/etc/postgresql/9.3/main/postgresql.conf"
postgres_pg_hba_file="/etc/postgresql/9.3/main/pg_hba.conf"
default_apache_index="/var/www/html/index.html"
symfony_parameters_file="/vagrant/app/config/parameters.yml"

# This function is called at the very bottom of the file
main() {

    if [[ -e /var/lock/vagrant-provision ]]; then
        cat 1>&2 <<EOI
################################################################################
# To re-run full provisioning, delete /var/lock/vagrant-provision and run
#
#    $ vagrant provision
#
# From the host machine
################################################################################
EOI
        exit
    fi

    update_go
    network_go
    tools_go
    apache_go
    php_go
    postgres_go
    composer_go
    bower_go
    project_config_go

    touch /var/lock/vagrant-provision

    cat 1>&2 <<EOI
################################################################################
# Machine up and ready to program!
# Connect to HTTP here: http://127.0.0.1:8888/app_dev.php
# Connect to HTTPS here: https://127.0.0.1:8889/app_dev.php
# Connect to Postgres here: 127.0.0.1:8890 (postgres:postgres authentication)
################################################################################
# ATENTION: Put the right values for:
#     app/config/parameters.yml
# ..and connect to the machine with:
#     vagrant ssh
################################################################################
EOI
}

update_go() {
    apt-get update
    apt-get -y upgrade
}

network_go() {
    IPADDR=$(/sbin/ifconfig eth0 | awk '/inet / { print $2 }' | sed 's/addr://')
    sed -i "s/^${IPADDR}.*//" /etc/hosts
    echo ${IPADDR} ubuntu.localhost >> /etc/hosts			# Just to quiet down some error messages
}

tools_go() {
    apt-get -y install build-essential binutils-doc git npm nodejs
}

apache_go() {
    apt-get -y install apache2
    sed -i "s/^\(.*\)www-data/\1vagrant/g" ${apache_config_file}
    chown -R vagrant:vagrant /var/log/apache2
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /home/vagrant/server.key -out /home/vagrant/server.crt -subj "/C=ES/ST=Alicante/L=Alicante/O=OBMS/OU=IT Department/CN=obms.local" -passin pass:""

    cat <<EOI > ${apache_vhost_file}
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /vagrant/web
    LogLevel debug

    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined

    <Directory /vagrant/web>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
<VirtualHost *:443>
    DocumentRoot /vagrant/web
    LogLevel debug

    ErrorLog /var/log/apache2/error.ssl.log
    CustomLog /var/log/apache2/access.ssl.log combined

    <Directory /vagrant/web>
        Options Indexes Includes
        Require all granted
    </Directory>

    SSLEngine on
    SSLCipherSuite ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP:+eNULL
    SSLCertificateFile /home/vagrant/server.crt
    SSLCertificateKeyFile /home/vagrant/server.key
</VirtualHost>
EOI

    a2dissite 000-default
    a2ensite vagrant_vhost
    a2enmod rewrite ssl
    service apache2 reload
    update-rc.d apache2 enable
    #service apache2 restart
}

php_go() {
    apt-get -y install php5 php5-curl php5-pgsql php5-sqlite php5-xdebug
    sed -i "s/display_startup_errors = Off/display_startup_errors = On/g" ${php_config_file}
    sed -i "s/display_errors = Off/display_errors = On/g" ${php_config_file}
    sed -i "s/max_execution_time = 30/max_execution_time = 300/g" ${phpcli_config_file}
    sed -i "s/max_input_time = 60/max_input_time = 600/g" ${phpcli_config_file}

    cat <<EOI > ${xdebug_config_file}
zend_extension=xdebug.so
xdebug.remote_enable=1
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_host=10.0.2.2
EOI

    service apache2 reload
}

postgres_go() {
    apt-get -y install postgresql

    sudo -u postgres psql<<EOI
\password postgres
postgres
postgres
\q
EOI

sed -i "s/#listen_addresses = 'localhost'/listen_addresses = '*'/g" ${postgres_conf_file}

    cat <<EOI > ${postgres_pg_hba_file}
local   all             all                                     md5
host    all             all             127.0.0.1/32            md5
host    all             all             10.0.2.2/32             md5
host    all             all             ::1/128                 md5
EOI

    service postgresql restart
}

composer_go() {
    php -r "readfile('https://getcomposer.org/installer');" | php
    mv composer.phar /usr/local/bin/composer
    chown root:root /usr/local/bin/composer
    chmod 755 /usr/local/bin/composer

    cat <<EOI > ${composer_config_file}
{
    "config": {
        "process-timeout":      600,
        "preferred-install":    "dist",
        "github-protocols":     ["https"]
    }
}
EOI
}

bower_go() {
    npm install -g bower
    #ln -s /usr/bin/nodejs /usr/bin/node
}

project_config_go() {
    cd /vagrant
    if [[ -d /vagrant/vendor ]]; then
        rm -r /vagrant/vendor
    fi

    cat <<EOI > ${symfony_parameters_file}
parameters:
    database_driver: pdo_pgsql
    database_host: 127.0.0.1
    database_port: 5432
    database_name: obms
    database_user: postgres
    database_password: postgres
    mailer_transport: smtp
    mailer_host: mail.yoursite.com
    mailer_user: web@yoursite.com
    mailer_password: thePasswordOfYourEmail
    locale: en
    secret: ThisTokenIsNotSoSecretChangeIt
EOI

    composer install --prefer-source --no-interaction --optimize-autoloader
    bower update --allow-root
    php app/console doctrine:database:create
    php app/console doctrine:schema:create
    php app/console doctrine:fixtures:load --no-interaction
    php app/console sample:data
    if [[ -d /vagrant/app/cache/prod ]]; then
        rm -r /vagrant/app/cache/prod
    fi
    if [[ -d /vagrant/app/cache/dev ]]; then
        rm -r /vagrant/app/cache/dev
    fi
}

main
exit 0
