#!/bin/bash
cd /var/www/html/letter-safe/ \
        && { \
            echo "<?php"; \
            echo "return ["; \
            echo "    'class' => 'yii\db\Connection',"; \
            echo "    'dsn' => 'mysql:host=$LETTERSAFE_DB_SERVER;dbname=$LETTERSAFE_DB_DB',"; \
            echo "    'username' => '$LETTERSAFE_DB_USER',"; \
            echo "    'password' => '$LETTERSAFE_DB_PASSWORD',"; \
            echo "    'charset' => 'utf8',"; \
            echo "];"; \
        } > ./config/db.php \
        && cat ./config/db.php \
        && php yii migrate --interactive=0
