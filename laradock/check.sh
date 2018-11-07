#!/bin/bash
prcNum=$(ps -aux|grep alimtok|grep -v grep|wc -l)
if [ $prcNum -lt 2 ] ; then
  cd /data/docker/laradock/laradock && /usr/local/bin/docker-compose exec -d --user=laradock workspace php /var/www/public/rabbitmq/alimtok.php &
  echo "startd" 
fi  
