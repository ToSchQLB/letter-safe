#!/bin/bash
cd /var/www/html/letter-safe/ 
{ \
    echo "<?php"; \
    echo "return ["; \
    echo "    'class' => 'yii\db\Connection',"; \
    echo "    'dsn' => 'mysql:host=$LETTERSAFE_DB_SERVER;dbname=$LETTERSAFE_DB_DB',"; \
    echo "    'username' => '$LETTERSAFE_DB_USER',"; \
    echo "    'password' => '$LETTERSAFE_DB_PASSWORD',"; \
    echo "    'charset' => 'utf8',"; \
    echo "];"; \
} > ./config/db.php
echo "<?php return ['tesseract-cmd' => '$TESSERACT_CMD','tesseract-path' => $TESSERACT_PATH];" > /var/www/html/letter-safe/config/tesseract.php
php /var/www/html/letter-safe/yii queue/unlock-queue
service cron start
php yii migrate --interactive=0 > /dev/null 
apache2-foreground
