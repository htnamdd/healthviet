#!/bin/bash
echo "php bin/magento maintenance:enable"
php bin/magento maintenance:enable

#echo "pull code from master"
git pull remote master

echo "composer install"
#composer install

echo "run setup:upgrade"
php bin/magento s:up

echo "php bin/magento setup:di:compile"
php bin/magento setup:di:compile

echo "php bin/magento s:s:d -f"
php bin/magento set:sta:de -f vi_VN en_US


echo "php bin/mageno c:f"
php bin/magento c:f

echo "php bin/magento maintenance:disable"
php bin/magento maintenance:disable


echo "sudo chmod -R 777 generated/*"
sudo chmod -R 777 var/ pub/ generated/*

php bin/magento ca:f

echo "Done!"
