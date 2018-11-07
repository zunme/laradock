#!/bin/bash
prcNum=$(ps -aux|grep alimtok|grep -v grep|wc -l)
if [ $prcNum -lt 3 ] ; then
  /usr/bin/php /var/www/public/rabbitmq/alimtok.php &
  echo "start alim"
else
  echo "checked"
fi

prcNum2=$(ps -aux|grep jsonreceive.php|grep -v grep|wc -l)
if [ $prcNum2 -lt 1 ] ; then
  /usr/bin/php /var/www/public/rabbitmq/jsonreceive.php &
  echo "start receive"
else
  echo "ehcekd receive"
fi

