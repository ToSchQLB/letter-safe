<?php

use yii\db\Migration;

class m170103_203807_add_default_user extends Migration
{
    public function up()
    {
        $user = new \app\models\User();
        $user->username = "admin";
        $user->password = "admin";
        $user->save();
    }

    public function down()
    {
        echo "m170103_203807_add_default_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
