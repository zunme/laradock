sudo docker-compose exec -d --user=laradock workspace php /var/www/public/rabbitmq/jsonreceive.php & 
sudo docker-compose exec -d --user=laradock workspace php /var/www/public/rabbitmq/alimtok.php &
