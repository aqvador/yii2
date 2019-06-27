#!/bin/bash

#composer update
php yii migrate --migrationPath=@yii/rbac/migrations
php yii rbac/init
php  yii migrate