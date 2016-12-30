<?php

use yii\db\Migration;

class m161230_213017_create_user extends Migration
{
    const TABLE_NAME = "user";
    public function up()
    {
        $this->createTable(self::TABLE_NAME,[
            'id' => $this->primaryKey(),
            'username' => $this->string(100),
            'password' => $this->string(255),
            'email' => $this->string(255)
        ]);
    }

    public function down()
    {
       $this->dropTable(self::TABLE_NAME);
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
