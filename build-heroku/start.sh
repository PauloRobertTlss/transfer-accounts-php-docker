#!/bin/sh

ls -1

sudo chown -R www-data:www-data /var/log/nginx;
sudo chown -R 775 /etc/nginx/nginx.conf;
sudo chmod -R 775 /var/log/nginx

docker ps --format "{{.ID}}: {{.Command}}"
# set port number to be listened as $PORT or 8888
sed -i -E "s/TO_BE_REPLACED_WITH_PORT/${PORT:-8888}/" /etc/nginx/conf.d/*.conf
#sed -i -E "s/TO_BE_REPLACED_WITH_PORT/${PORT:-8888}/" /etc/nginx/conf.d/*.conf && nginx -g 'daemon off;'
echo "################## s/TO_BE_REPLACED_WITH_PORT/${PORT:-8888}/ @@@@@@@@@@@@@@@@@"
# "/var/tmp/nginx" owned by "nginx" user is unusable on heroku dyno so re-create on runtime
#mkdir /var/tmp/nginx
cat /etc/nginx/conf.d/default.conf
sudo /etc/init.d/nginx start
echo "################## php config #############################"
#php -m
#php -i | grep 'php.ini'
echo "################## php config #############################"
#cat /usr/local/etc/php/php.ini
#RUN sed -i 's/127.0.0.1:9000/0.0.0.0:9000/g' /etc/php7/php-fpm.d/www.conf
echo "################## php fpm config #############################"
#cat /etc/php7/php-fpm.d/www.conf


#sudo rm -rf  /etc/nginx/nginx.conf
#cat /etc/nginx/nginx/conf.d

## make php-fpm be able to listen request from nginx (current user is nginx executor)
sed -i -E "s/^;listen.owner = .*/listen.owner = $(whoami)/" /etc/php7/php-fpm.d/www.conf
#
## make current user the executor of nginx and php-fpm expressly for local environment
sed -i -E "s/^user = .*/user = $(whoami)/" /etc/php7/php-fpm.d/www.conf
sed -i -E "s/^group = (.*)/;group = \1/" /etc/php7/php-fpm.d/www.conf
sed -i -E "s/^user .*/user $(whoami);/" /etc/nginx/nginx.conf

#sudo service nginx restart
#sudo service php7.2-fpm restart
#
supervisord --nodaemon --configuration /etc/supervisord.conf